<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\SisaCuti;
use Carbon\Carbon;

class VerifikasiCutiController extends Controller
{
    /**
     * Menampilkan daftar pengajuan cuti yang perlu diverifikasi.
     */
    public function index(): View
    {
        $user = Auth::user();
        // Mulai query dengan eager loading untuk mengatasi N+1 problem.
        $query = Cuti::with('pegawai.opd');

        $atasanOpdId = optional($user->pegawai)->opd_id;

        // Admin melihat semua permintaan yang tertunda dari semua OPD.
        if ($user->hasRole('Admin')) {
            $query->whereIn('status', ['diajukan', 'disetujui_kabid']);
        }
        // Kabid melihat status 'diajukan' dari OPD-nya sendiri.
        elseif ($user->hasRole('Verif Cuti Kabid') && $atasanOpdId) {
            $query->where('status', 'diajukan')
                ->whereHas('pegawai', fn($q) => $q->where('opd_id', $atasanOpdId));
        }
        // KaOPD melihat status 'disetujui_kabid' dari OPD-nya sendiri.
        elseif ($user->hasRole('Verif Cuti KaOPD') && $atasanOpdId) {
            $query->where('status', 'disetujui_kabid')
                ->whereHas('pegawai', fn($q) => $q->where('opd_id', $atasanOpdId));
        }
        // Peran lain tidak melihat apa-apa.
        else {
            $query->whereRaw('0 = 1'); // Secara efektif mengembalikan koleksi kosong.
        }

        // Langsung panggil paginate di akhir query.
        $cutis = $query->latest()->paginate(10);

        return view('verifikasi-cuti.index', compact('cutis'));
    }

    /**
     * Menyetujui pengajuan cuti.
     */
    public function approve(Cuti $cuti)
    {
        $user = Auth::user();
        $namaApprover = $user->name;
        $message = '';

        if (($user->hasRole('Verif Cuti Kabid') || $user->hasRole('Admin')) && $cuti->status === 'diajukan') {
            $cuti->update([
                'status' => 'disetujui_kabid',
                'id_kabid' => $user->id,
                'tgl_disetujui_kabid' => now()
            ]);
            $message = "Pengajuan cuti berhasil disetujui oleh {$namaApprover} dan diteruskan ke Kepala OPD.";
        } elseif (($user->hasRole('Verif Cuti KaOPD') || $user->hasRole('Admin')) && $cuti->status === 'disetujui_kabid') {
            $cuti->update([
                'status' => 'disetujui_kaopd',
                'id_kaopd' => $user->id,
                'tgl_disetujui_kaopd' => now()
            ]);

            if ($cuti->jenis_cuti === 'Cuti Tahunan') {
                $tahunCuti = Carbon::parse($cuti->tanggal_mulai)->year;
                $sisaCuti = SisaCuti::firstOrCreate(
                    ['pegawai_id' => $cuti->pegawai_id, 'tahun' => $tahunCuti]
                );

                $tanggalMulai = Carbon::parse($cuti->tanggal_mulai);
                $tanggalSelesai = Carbon::parse($cuti->tanggal_selesai);
                $lamaCuti = $tanggalMulai->diffInDaysFiltered(function (Carbon $date) {
                    return !$date->isWeekend();
                }, $tanggalSelesai) + 1;

                $sisaCuti->increment('jatah_cuti_diambil', $lamaCuti);
            }

            $message = "Pengajuan cuti berhasil disetujui sepenuhnya oleh {$namaApprover}.";
        } else {
            return redirect()->route('verifikasi-cuti.index')->with('error', 'Anda tidak memiliki hak untuk menyetujui ajuan ini atau status ajuan tidak sesuai.');
        }

        return redirect()->route('verifikasi-cuti.index')->with('success', $message);
    }

    /**
     * Menolak pengajuan cuti.
     */
    public function reject(Request $request, Cuti $cuti)
    {
        $request->validate(['keterangan_penolakan' => 'required|string|min:5']);
        $user = Auth::user();

        $updateData = [
            'status' => 'ditolak',
            'keterangan_penolakan' => $request->keterangan_penolakan
        ];

        if ($user->hasRole('Verif Cuti Kabid') || $user->hasRole('Admin')) {
            $updateData['id_kabid'] = $user->id;
        } elseif ($user->hasRole('Verif Cuti KaOPD')) {
            $updateData['id_kaopd'] = $user->id;
        }

        $cuti->update($updateData);

        return redirect()->route('verifikasi-cuti.index')->with('success', 'Pengajuan cuti telah ditolak.');
    }

    /**
     * Menampilkan detail pengajuan cuti untuk diverifikasi.
     */
    public function show(Cuti $cuti): View
    {
        $daftarBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
        return view('verifikasi-cuti.show', compact('cuti', 'daftarBulan'));
    }
}
