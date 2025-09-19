<?php

namespace App\Http\Controllers;

use App\Models\PengajuanTpp;
use App\Models\User;
use App\Notifications\TppDisetujuiNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class VerifikasiTppController extends Controller
{
    /**
     * Menampilkan daftar pengajuan yang perlu diverifikasi.
     */
    public function index()
    {
        // Ambil semua pengajuan yang statusnya 'diajukan'
        $pengajuanTpps = PengajuanTpp::where('status', 'diajukan')
            ->with('opd')
            ->latest()
            ->paginate(10);

        $daftarBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];

        return view('verifikasi-tpp.index', compact('pengajuanTpps', 'daftarBulan'));
    }

    /**
     * Menyetujui (approve) sebuah pengajuan.
     */
    public function approve(Request $request, PengajuanTpp $pengajuanTpp)
    {
        // ▼▼▼ TAMBAHKAN VALIDASI INI ▼▼▼
        if ($pengajuanTpp->besaran_tpp_diajukan <= 0) {
            return redirect()->back()
                ->with('error', 'Gagal menyetujui. Harap isi dan simpan nominal Besaran TPP terlebih dahulu sebelum menyetujui pengajuan.');
        }
        // ▲▲▲ BATAS AKHIR VALIDASI ▲▲▲

        $pengajuanTpp->update([
            'status' => 'disetujui',
            'keterangan' => null, // Hapus keterangan penolakan jika ada
        ]);

        // Kirim notifikasi ke user yang membuat pengajuan bahwa pengajuannya disetujui
        if ($pengajuanTpp->user) {
            Notification::send($pengajuanTpp->user, new TppDisetujuiNotification($pengajuanTpp));
        }

        return redirect()->route('verifikasi-tpp.index')
            ->with('success', 'Pengajuan TPP telah berhasil disetujui.');
    }
    /**
     * Menolak (reject) sebuah pengajuan.
     */
    public function reject(Request $request, PengajuanTpp $pengajuanTpp)
    {
        $request->validate([
            'keterangan' => 'required|string|min:10',
        ]);

        // Ubah status menjadi 'perlu_perbaikan'
        $pengajuanTpp->update([
            'status' => 'perlu_perbaikan',
            'keterangan' => $request->keterangan,
        ]);

        // Cari user pengelola dari OPD yang bersangkutan untuk dikirim notifikasi
        $pengelolaOpd = User::role('Operator TPP')->whereHas('pegawai', function ($query) use ($pengajuanTpp) {
            $query->where('opd_id', $pengajuanTpp->opd_id);
        })->first();

        if ($pengelolaOpd) {
            // Kita akan buat notifikasi ini di langkah berikutnya
            // Notification::send($pengelolaOpd, new TppPerluPerbaikanNotification($pengajuanTpp));
        }

        return redirect()->route('verifikasi-tpp.index')
            ->with('success', 'Pengajuan TPP telah dikembalikan ke pengelola untuk perbaikan.');
    }

    public function updateBesaran(Request $request, PengajuanTpp $pengajuanTpp)
    {
        $validated = $request->validate([
            'besaran_tpp_diajukan' => 'required|numeric|min:0',
        ]);

        $pengajuanTpp->update([
            'besaran_tpp_diajukan' => $validated['besaran_tpp_diajukan'],
        ]);

        return redirect()->back()->with('success', 'Besaran TPP berhasil disimpan.');
    }

    public function show(Request $request, PengajuanTpp $pengajuanTpp)
    {
        // Validasi hash untuk keamanan URL
        if (!hash_equals($pengajuanTpp->getRouteHash(), $request->hash)) {
            abort(403, 'URL TIDAK VALID ATAU TELAH KADALUARSA.');
        }

        // Eager load the OPD relationship to ensure it's available
        $pengajuanTpp->load('opd');

        // Ambil daftar bulan untuk ditampilkan di view
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

        // Arahkan ke view baru yang akan kita buat
        return view('verifikasi-tpp.show', [
            'pengajuanTpp' => $pengajuanTpp,
            'daftarBulan' => $daftarBulan
        ]);
    }
}
