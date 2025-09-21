<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\SisaCuti;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View; // Import View untuk type-hinting

class CutiController extends Controller
{
    /**
     * Menampilkan riwayat cuti milik pengguna yang login.
     */
    public function index(): View
    {
        $pegawai = Auth::user()->pegawai;

        // Ambil data cuti jika user memiliki profil pegawai
        $cutis = $pegawai ? $pegawai->cutis()->latest()->paginate(10) : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);

        return view('cuti.index', compact('cutis'));
    }

    /**
     * Menampilkan form pengajuan cuti.
     */
    public function create()
    {
        $pegawai = Auth::user()->pegawai;
        if (!$pegawai) {
            return redirect()->route('cuti.index')->with('error', 'Profil pegawai Anda tidak ditemukan untuk menghitung sisa cuti, harap untuk mengisi profil Anda terlebih dahulu.');
        }

        $sisaCuti = SisaCuti::where('pegawai_id', $pegawai->id)->where('tahun', date('Y'))->first();

        $totalSisaCuti = 12; // Jatah dasar
        if ($sisaCuti) {
            $totalSisaCuti = (12 - $sisaCuti->jatah_cuti_diambil) + $sisaCuti->sisa_cuti_tahun_lalu + $sisaCuti->sisa_cuti_2_tahun_lalu;
        }

        return view('cuti.create', compact('totalSisaCuti'));
    }

    /**
     * Menyimpan pengajuan cuti baru.
     */
    public function store(Request $request)
    {
        $user = Auth::user(); // Ambil data user yang login
        $pegawai = $user->pegawai;
        if (!$pegawai) {
            return redirect()->route('cuti.index')->with('error', 'Profil pegawai Anda tidak ditemukan.');
        }

        $request->validate([
            'jenis_cuti' => 'required|string',
            // === PENAMBAHAN VALIDASI TANGGAL ===
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            // ===================================
            'tanggal_selesai' => [
                'required',
                'date',
                'after_or_equal:tanggal_mulai',
                function ($attribute, $value, $fail) use ($request, $pegawai) {
                    $tanggalMulai = Carbon::parse($request->tanggal_mulai);
                    $tanggalSelesai = Carbon::parse($value);

                    $existingCuti = Cuti::where('pegawai_id', $pegawai->id)
                        ->whereIn('status', ['diajukan', 'disetujui_kabid', 'disetujui_kaopd'])
                        ->where(function ($query) use ($tanggalMulai, $tanggalSelesai) {
                            $query->where(function ($q) use ($tanggalMulai, $tanggalSelesai) {
                                $q->where('tanggal_mulai', '<=', $tanggalSelesai)
                                    ->where('tanggal_selesai', '>=', $tanggalMulai);
                            });
                        })
                        ->exists();

                    if ($existingCuti) {
                        $fail('Anda sudah memiliki pengajuan atau jadwal cuti yang disetujui pada rentang tanggal tersebut.');
                    }
                },
            ],
            'keterangan' => 'required|string|min:10',
            'file_lampiran' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ], [
            // Pesan error kustom untuk aturan after_or_equal
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai cuti tidak boleh tanggal yang sudah lewat.',
        ]);

        $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
        $lamaCuti = $tanggalMulai->diffInDaysFiltered(fn(Carbon $date) => !$date->isWeekend(), $tanggalSelesai) + 1;

        // --- VALIDASI BERDASARKAN JENIS CUTI ---
        switch ($request->jenis_cuti) {
            case 'Cuti Tahunan':
                if (optional($pegawai->tmt_pns) && Carbon::parse($pegawai->tmt_pns)->diffInYears(now()) < 1) {
                    return back()->with('error', 'Anda belum memenuhi syarat masa kerja minimal 1 tahun untuk Cuti Tahunan.');
                }

                $sisaCuti = SisaCuti::firstOrCreate(['pegawai_id' => $pegawai->id, 'tahun' => date('Y')]);
                $totalSisaCuti = (12 - $sisaCuti->jatah_cuti_diambil) + $sisaCuti->sisa_cuti_tahun_lalu + $sisaCuti->sisa_cuti_2_tahun_lalu;

                if ($lamaCuti > $totalSisaCuti) {
                    return back()->with('error', "Jatah cuti tahunan Anda tidak mencukupi. Sisa cuti Anda: {$totalSisaCuti} hari.");
                }
                break;

            case 'Cuti Melahirkan':
                if (strtoupper($pegawai->jenis_kelamin) !== 'P') {
                    return back()->with('error', 'Cuti melahirkan hanya untuk PNS perempuan.');
                }
                if ($lamaCuti > 90) { // 3 bulan ~ 90 hari
                    return back()->with('error', 'Durasi cuti melahirkan maksimal 3 bulan.');
                }
                break;

            case 'Cuti Karena Alasan Penting':
                if ($lamaCuti > 30) { // 1 bulan ~ 30 hari
                    return back()->with('error', 'Durasi Cuti Karena Alasan Penting maksimal 1 bulan.');
                }
                break;

            case 'Cuti di Luar Tanggungan Negara':
                if (optional($pegawai->tmt_pns) && Carbon::parse($pegawai->tmt_pns)->diffInYears(now()) < 5) {
                    return back()->with('error', 'Anda belum memenuhi syarat masa kerja minimal 5 tahun untuk CLTN.');
                }
                break;
        }

        $lampiranPath = null;
        if ($request->hasFile('file_lampiran')) {
            $lampiranPath = $request->file('file_lampiran')->store('lampiran-cuti', 'public');
        }

        // ==========================================================
        // BAGIAN YANG DISESUAIKAN: Logika Status Berdasarkan Peran
        // ==========================================================
        $dataCuti = [
            'pegawai_id' => $pegawai->id,
            'jenis_cuti' => $request->jenis_cuti,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
            'file_lampiran' => $lampiranPath,
        ];

        if ($user->hasRole('Kepala Bidang')) {
            // Jika yang mengajukan adalah Kepala Bidang, status langsung 'disetujui_kabid'
            $dataCuti['status'] = 'disetujui_kabid';
            $dataCuti['id_kabid'] = $user->id;
            $dataCuti['tgl_disetujui_kabid'] = now();
        } else {
            // Untuk peran lain, statusnya normal 'diajukan'.
            $dataCuti['status'] = 'diajukan';
        }

        Cuti::create($dataCuti);

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil dikirim.');
    }
}
