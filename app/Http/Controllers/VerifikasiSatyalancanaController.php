<?php

namespace App\Http\Controllers;

use App\Models\Satyalancana;
use App\Notifications\SatyalancanaPerluPerbaikanNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class VerifikasiSatyalancanaController extends Controller
{
    public function index(Request $request): View
    {
        // ... (Fungsi index() Anda sudah benar, tidak perlu diubah) ...
        $periodes = Satyalancana::select('periode')->whereNotNull('periode')->distinct()
            ->orderBy('tahun_pengusulan', 'desc')
            ->orderByRaw("FIELD(SUBSTRING_INDEX(periode, ' ', 1), 'November', 'Agustus')")
            ->pluck('periode');

        $query = Satyalancana::with('pegawai.opd');

        if ($request->filled('periode')) {
            $query->where('periode', $request->periode);
        }

        $usulans = $query->latest()->paginate(10)->withQueryString();
        return view('verifikasi-satyalancana.index', compact('usulans', 'periodes'));
    }

    public function show(Satyalancana $satyalancana): View
    {
        $satyalancana->load('pegawai.user', 'pegawai.opd', 'diverifikasiOleh');
        return view('verifikasi-satyalancana.show', compact('satyalancana'));
    }

    /**
     * ▼▼▼ PERBAIKI FUNGSI INI ▼▼▼
     */
    public function approve(Satyalancana $satyalancana)
    {
        $satyalancana->update([
            'status' => 'disetujui',
            'diverifikasi_oleh' => Auth::id(),
            'tanggal_verifikasi' => now(),
        ]);

        // Redirect kembali ke halaman detail, bukan ke index
        return redirect()->route('verifikasi-satyalancana.show', $satyalancana)
            ->with('success', 'Usulan penghargaan berhasil disetujui.');
    }

    /**
     * ▼▼▼ PERBAIKI FUNGSI INI ▼▼▼
     */
    public function reject(Request $request, Satyalancana $satyalancana)
    {
        $request->validate(['keterangan' => 'required|string|min:10'], [
            'keterangan.required' => 'Alasan penolakan (keterangan) wajib diisi.'
        ]);

        $satyalancana->update([
            'status' => 'perlu_perbaikan',
            'keterangan' => $request->keterangan,
            'diverifikasi_oleh' => Auth::id(),
            'tanggal_verifikasi' => now(),
        ]);

        if ($satyalancana->pegawai && $satyalancana->pegawai->user) {
            Notification::send($satyalancana->pegawai->user, new SatyalancanaPerluPerbaikanNotification($satyalancana));
            $satyalancana->pegawai->user->limitNotifications();
        }

        // Redirect kembali ke halaman detail, bukan ke index
        return redirect()->route('verifikasi-satyalancana.show', $satyalancana)
            ->with('success', 'Usulan telah dikembalikan kepada pegawai untuk perbaikan.');
    }

    public function viewBerkas(Satyalancana $satyalancana, $field)
    {
        // Daftar kolom berkas yang valid untuk keamanan
        $allowedFields = [
            'file_drh', 'file_sk_cpns', 'file_sk_pangkat_terakhir', 'file_sk_jabatan_terakhir',
            'file_surat_pernyataan_disiplin', 'file_skp', 'file_sptjm', 'file_piagam_sebelumnya'
        ];

        if (!in_array($field, $allowedFields)) {
            abort(404, 'Berkas tidak valid.');
        }

        $filePath = $satyalancana->{$field};

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->file(storage_path('app/public/' . $filePath));
    }
}
