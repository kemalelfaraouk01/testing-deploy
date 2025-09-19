<?php

namespace App\Console\Commands;

use App\Models\Pegawai;
use App\Models\RiwayatJabatan;
use App\Models\RiwayatPangkat;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncPegawaiFromKinerja extends Command
{
    protected $signature = 'sync:pegawai-kinerja';
    protected $description = 'Sinkronisasi data jabatan dan pangkat pegawai dari API Kinerja';

    public function handle()
    {
        $this->info('Memulai sinkronisasi data pegawai dari API Kinerja...');

        $pegawais = Pegawai::with(['user'])->get();

        if ($pegawais->isEmpty()) {
            $this->info('Tidak ada pegawai untuk disinkronkan.');
            return 0;
        }

        $bar = $this->output->createProgressBar($pegawais->count());
        $bar->start();

        foreach ($pegawais as $pegawai) {
            if (empty($pegawai->user->nip) || !is_string($pegawai->user->nip)) {
                $bar->advance();
                continue;
            }

            $nip = $pegawai->user->nip;
            $url = "https://kinerja.bengkulukota.go.id/api/pegawai/{$nip}/get_pegawai";
            $statusPesan = 'sudah sinkron.';
            $user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36';

            try {
                Log::info("--- Memproses NIP: [{$nip}] ---");

                $safe_url = escapeshellarg($url);
                $safe_user_agent = escapeshellarg($user_agent);
                $curl_command = "curl -s -L --insecure -A {$safe_user_agent} {$safe_url}";

                Log::info("Generated cURL command: " . $curl_command);

                $response_json = shell_exec($curl_command);

                Log::info("Raw shell_exec output: " . ($response_json ?? '[null]'));

                if (empty($response_json)) {
                    $statusPesan = 'gagal dihubungi (curl kosong)';
                    Log::warning("Gagal mengambil data via cURL untuk NIP: {$nip}. Respons kosong.");
                } else {
                    $response_data = json_decode($response_json, true);

                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $statusPesan = 'respons JSON tidak valid';
                        Log::error("Gagal memparsing JSON untuk NIP: {$nip}. Error: " . json_last_error_msg());
                    } else {
                        $data = $response_data[0] ?? null;

                        if (empty($data)) {
                            $statusPesan = 'tidak ditemukan di API.';
                            Log::info("Data untuk NIP: {$nip} tidak ditemukan di API.");
                        } else {
                            Log::info("Data dari API untuk NIP: {$nip}: " . json_encode($data));
                            try {
                                DB::transaction(function () use ($pegawai, $data, &$statusPesan) {
                                    $updated = false;

                                    // Log data saat ini di database
                                    Log::info("Data saat ini di database untuk pegawai ID {$pegawai->id}: Jabatan: {$pegawai->jabatan}, Pangkat: {$pegawai->pangkat}");

                                    $apiJabatan = $data['jabatan'] ?? null;
                                    if ($apiJabatan) {
                                        $apiJabatan = trim($apiJabatan);
                                        Log::info("Jabatan dari API: {$apiJabatan}");
                                        if (trim($pegawai->jabatan) !== $apiJabatan) {
                                            Log::info("Jabatan berbeda, akan diupdate.");
                                            $pegawai->jabatan = $apiJabatan;
                                            RiwayatJabatan::create([
                                                'pegawai_id' => $pegawai->id,
                                                'jabatan' => $apiJabatan
                                            ]);
                                            $updated = true;
                                        } else {
                                            Log::info("Jabatan sama, tidak diupdate.");
                                        }
                                    } else {
                                        Log::warning("Jabatan dari API kosong untuk NIP: {$pegawai->user->nip}");
                                    }

                                    $apiPangkat = $data['pangkat'] ?? null;
                                    if ($apiPangkat) {
                                        $apiPangkat = trim($apiPangkat);
                                        Log::info("Pangkat dari API: {$apiPangkat}");
                                        if (trim($pegawai->pangkat) !== $apiPangkat) {
                                            Log::info("Pangkat berbeda, akan diupdate.");
                                            RiwayatPangkat::create([
                                                'pegawai_id' => $pegawai->id,
                                                'pangkat' => $apiPangkat
                                            ]);
                                            $pegawai->pangkat = $apiPangkat;
                                            $updated = true;
                                        } else {
                                            Log::info("Pangkat sama, tidak diupdate.");
                                        }
                                    } else {
                                        Log::warning("Pangkat dari API kosong untuk NIP: {$pegawai->user->nip}");
                                    }

                                    if ($updated) {
                                        $pegawai->save();
                                        $statusPesan = 'berhasil diperbarui.';
                                        Log::info("Data pegawai ID {$pegawai->id} berhasil diperbarui.");
                                    } else {
                                        $statusPesan = 'tidak ada perubahan.';
                                        Log::info("Tidak ada perubahan data untuk pegawai ID {$pegawai->id}.");
                                    }
                                });
                            } catch (\Exception $e) {
                                $statusPesan = 'gagal menyimpan data.';
                                Log::error("Error transaksi untuk NIP: {$nip}. Pesan: " . $e->getMessage());
                                Log::error($e->getTraceAsString());
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                $statusPesan = 'error.';
                Log::error("Error saat sinkronisasi NIP: {$nip}. Pesan: " . $e->getMessage());
                Log::error($e->getTraceAsString());
            }

            $bar->advance();
            $bar->setMessage("NIP: {$nip} - {$statusPesan}");
        }

        $bar->finish();
        $this->info("\nSinkronisasi data pegawai selesai.");
        return 0;
    }
}
