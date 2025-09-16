<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Satyalancana;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SatyalancanaDiajukanNotification;

class SatyalancanaController extends Controller
{
    /**
     * Menampilkan halaman daftar kandidat yang memenuhi syarat.
     */
    public function index()
    {
        $pegawais = Pegawai::with('user', 'opd')->get();
        $tahunIni = date('Y');
        $eligible = ['x' => [], 'xx' => [], 'xxx' => []];

        foreach ($pegawais as $pegawai) {
            if (!$pegawai->tmt_cpns) continue;

            try {
                $tanggalMulaiKerja = Carbon::parse($pegawai->tmt_cpns);
            } catch (\Exception $e) {
                continue;
            }

            $masaKerja = $tanggalMulaiKerja->diffInYears(now());
            $sudahDiusulkan = $pegawai->satyalancanas()->where('tahun_pengusulan', $tahunIni)->exists();
            if ($sudahDiusulkan) continue;

            $data = ['pegawai' => $pegawai, 'masaKerja' => $masaKerja];

            if ($masaKerja >= 30) $eligible['xxx'][] = $data;
            elseif ($masaKerja >= 20) $eligible['xx'][] = $data;
            elseif ($masaKerja >= 10) $eligible['x'][] = $data;
        }

        // Daftar periode untuk dipilih secara manual oleh operator
        $daftarPeriode = [
            "Agustus {$tahunIni}" => "Agustus {$tahunIni}",
            "November {$tahunIni}" => "November {$tahunIni}",
        ];

        return view('satyalancana.index', compact('eligible', 'daftarPeriode'));
    }

    /**
     * ▼▼▼ INI FUNGSI YANG DIPERBAIKI ▼▼▼
     * Menyimpan usulan Satyalancana untuk banyak pegawai dari halaman index.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_ids' => 'required|array|min:1',
            'pegawai_ids.*' => 'exists:pegawais,id',
            'masa_kerja' => 'required|in:10,20,30',
            'periode' => 'required|string', // Validasi periode
        ], [
            'pegawai_ids.required' => 'Anda harus memilih (mencentang) setidaknya satu pegawai untuk diusulkan.',
        ]);

        $tahun = Carbon::now()->year;
        $jenisPenghargaan = 'Satyalancana Karya Satya ' . $request->masa_kerja . ' Tahun';
        $berhasil = 0;

        foreach ($request->pegawai_ids as $pegawaiId) {
            $existing = Satyalancana::where('pegawai_id', $pegawaiId)
                ->where('tahun_pengusulan', $tahun)
                ->exists();

            if (!$existing) {
                $usulan = Satyalancana::create([
                    'pegawai_id' => $pegawaiId,
                    'jenis_penghargaan' => $jenisPenghargaan,
                    'masa_kerja' => $request->masa_kerja,
                    'tahun_pengusulan' => $tahun,
                    'periode' => $request->periode, // Simpan periode dari form
                    'status' => 'menunggu_kelengkapan_berkas',
                ]);

                $pegawai = Pegawai::find($pegawaiId);
                if ($pegawai && $pegawai->user) {
                    Notification::send($pegawai->user, new SatyalancanaDiajukanNotification($usulan));
                    $pegawai->user->limitNotifications();
                }
                $berhasil++;
            }
        }

        return redirect()->route('satyalancana.index')
            ->with('success', "$berhasil pegawai berhasil diusulkan untuk periode " . $request->periode);
    }


    /**
     * Fungsi-fungsi di bawah ini untuk halaman 'My Proposals' milik pegawai,
     * biarkan saja seperti semula.
     */
    public function myProposals()
    {
        $user = Auth::user();

        $usulans = Satyalancana::whereHas('pegawai', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->latest()
        ->paginate(10);

        return view('satyalancana.my-proposals', compact('usulans'));
    }
}
