<?php

namespace App\Imports;

use App\Models\Opd;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Bus\Batchable;

class PegawaiImport implements ToCollection, WithHeadingRow, WithValidation, WithChunkReading, ShouldQueue
{
    use Batchable;

    private $opds;

    public function __construct()
    {
        // Langkah 1: Ambil semua data OPD sekali saja di awal untuk efisiensi.
        // Ini mengubah ribuan query menjadi satu query saja.
        $this->opds = Opd::pluck('id', 'nama_opd');
    }

    /**
     * Fungsi untuk mengubah tanggal Excel menjadi format Y-m-d jika valid.
     */
    private function transformDate($value)
    {
        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value)->format('Y-m-d');
        }
        return null;
    }

    public function collection(Collection $rows)
    {
        $usersToUpsert = [];
        $pegawaisToUpsert = [];
        $nipsInChunk = $rows->pluck('nip')->all();

        sleep(2);

        // Siapkan data untuk tabel 'users'
        foreach ($rows as $row) {
            $usersToUpsert[] = [
                'nip' => $row['nip'],
                'name' => $row['nama_lengkap'],
                'password' => Hash::make('password123'), // Password default untuk user baru
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // --- Operasi Massal untuk Tabel Users ---
        // Langkah 2: Buat atau update semua user dalam satu perintah `upsert`.
        User::upsert($usersToUpsert, ['nip'], ['name', 'password', 'updated_at']);

        // Ambil semua user yang baru saja kita proses dalam chunk ini
        $processedUsers = User::whereIn('nip', $nipsInChunk)->pluck('id', 'nip');

        // Cek user mana yang baru dibuat untuk diberi peran 'User'
        $newlyCreatedUsers = User::whereIn('nip', $nipsInChunk)->where('created_at', '>=', now()->subSeconds(10))->get();
        foreach ($newlyCreatedUsers as $newUser) {
            $newUser->assignRole('User');
        }

        // Siapkan data untuk tabel 'pegawais'
        foreach ($rows as $row) {
            // Ambil ID OPD dari koleksi yang sudah kita siapkan, tanpa query baru ke database
            $opdId = $this->opds->get($row['nama_opd']);

            $pegawaisToUpsert[] = [
                'user_id' => $processedUsers[$row['nip']],
                'opd_id' => $opdId,
                'nama_lengkap' => $row['nama_lengkap'],
                'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
                'agama' => $row['agama'] ?? null,
                'status_perkawinan' => $row['status_perkawinan'] ?? null,
                'tanggal_lahir' => $this->transformDate($row['tanggal_lahir']),
                'alamat' => $row['alamat'] ?? null,
                'no_hp' => $row['no_hp'] ?? null,
                'email' => $row['email'] ?? null,
                'jabatan' => $row['jabatan'] ?? null,
                'jenis_jabatan' => $row['jenis_jabatan'] ?? null,
                'pangkat' => $row['pangkat'] ?? null,
                'golongan' => $row['golongan'] ?? null,
                'unit_kerja' => $row['unit_kerja'] ?? null,
                'status_kepegawaian' => $row['status_kepegawaian'] ?? null,
                'jenis_kepegawaian' => $row['jenis_kepegawaian'] ?? null,
                'tmt_cpns' => $this->transformDate($row['tmt_cpns']),
                'tmt_pns' => $this->transformDate($row['tmt_pns']),
                'tmt_jabatan' => $this->transformDate($row['tmt_jabatan']),
                'nomor_sk_cpns' => $row['nomor_sk_cpns'] ?? null,
                'nomor_sk_pns' => $row['nomor_sk_pns'] ?? null,
                'pendidikan_terakhir' => $row['pendidikan_terakhir'] ?? null,
                'jurusan' => $row['jurusan'] ?? null,
                'asal_sekolah' => $row['asal_sekolah'] ?? null,
                'tahun_lulus' => $row['tahun_lulus'] ?? null,
                'npwp' => $row['npwp'] ?? null,
                'bpjs_kesehatan' => $row['bpjs_kesehatan'] ?? null,
                'bpjs_ketenagakerjaan' => $row['bpjs_ketenagakerjaan'] ?? null,
                'rekening_bank' => $row['rekening_bank'] ?? null,
                'nama_bank' => $row['nama_bank'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // --- Operasi Massal untuk Tabel Pegawai ---
        // Langkah 3: Buat atau update semua profil pegawai dalam satu perintah `upsert`.
        if (!empty($pegawaisToUpsert)) {
            Pegawai::upsert($pegawaisToUpsert, ['user_id'], array_keys($pegawaisToUpsert[0]));
        }
    }

    public function chunkSize(): int
    {
        return 500; // Tetap proses 500 baris per batch untuk menjaga memori tetap ringan
    }

    public function rules(): array
    {
        return [
            '*.nip' => ['required', 'distinct'],
            '*.nama_lengkap' => ['required', 'string'],
            '*.nama_opd' => ['nullable', 'string'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.nip.required' => 'Kolom nip wajib diisi.',
            '*.nip.distinct' => 'Terdapat NIP duplikat di dalam file Excel.',
            '*.nama_lengkap.required' => 'Kolom nama_lengkap wajib diisi.',
        ];
    }
}
