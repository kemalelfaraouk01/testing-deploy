<?php

namespace App\Http\Controllers;

use App\Models\Satyalancana;
use App\Models\User;
use App\Notifications\BerkasSatyalancanaLengkapNotification; // Kita akan buat notifikasi ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BerkasSatyalancanaController extends Controller
{
    /**
     * Menampilkan form untuk melengkapi berkas.
     */
    public function show(Satyalancana $satyalancana): View
    {
        // Keamanan: pastikan hanya pegawai yang bersangkutan yang bisa akses
        if ($satyalancana->pegawai_id !== Auth::user()->pegawai->id) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('satyalancana.lengkapi-berkas', compact('satyalancana'));
    }

    /**
     * Mengupdate data usulan dengan berkas yang diunggah.
     */
    public function update(Request $request, Satyalancana $satyalancana)
    {
        // Keamanan
        if ($satyalancana->pegawai_id !== Auth::user()->pegawai->id) {
            abort(403);
        }

        $validatedData = $request->validate([
            'file_drh' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'file_sk_cpns' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'file_sk_pangkat_terakhir' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'file_sk_jabatan_terakhir' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'file_surat_pernyataan_disiplin' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'file_skp' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'file_sptjm' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_piagam_sebelumnya' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $paths = [];
        // Loop untuk mengunggah setiap file
        foreach (array_keys($validatedData) as $field) {
            if ($request->hasFile($field)) {
                // Hapus file lama jika ada
                if ($satyalancana->$field) {
                    Storage::disk('public')->delete($satyalancana->$field);
                }
                // Simpan file baru
                $paths[$field] = $request->file($field)->store('dokumen-satyalancana', 'public');
            }
        }

        // Update data di database dengan path file baru dan ubah status
        $satyalancana->update(array_merge($paths, ['status' => 'berkas_lengkap']));

        // Kirim notifikasi ke para verifikator
        $verifikator = User::role(['Admin', 'Kepala Bidang'])->get();
        if ($verifikator->isNotEmpty()) {
            Notification::send($verifikator, new BerkasSatyalancanaLengkapNotification($satyalancana));
        }

        return redirect()->route('dashboard')->with('success', 'Berkas Anda berhasil dikirim dan akan segera diverifikasi.');
    }
}
