<?php

namespace App\Http\Controllers;

use App\Models\Pensiun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BerkasPensiunController extends Controller
{
    /**
     * Menampilkan form untuk melengkapi berkas pensiun.
     */
    public function create(Request $request, $id)
    {
        $pensiun = Pensiun::findOrFail($id);
        if (!hash_equals($pensiun->getRouteHash(), $request->hash)) {
            abort(403, 'URL TIDAK VALID');
        }

        // Otorisasi: Pastikan hanya pegawai yang bersangkutan yang bisa mengakses
        if (Auth::user()->pegawai->id !== $pensiun->pegawai_id) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
        }

        $berkasFields = Pensiun::$berkasFields;
        return view('berkas-pensiun.create', compact('pensiun', 'berkasFields'));
    }

    /**
     * Menyimpan berkas yang diunggah oleh kandidat.
     */
    public function store(Request $request, $id)
    {
        $pensiun = Pensiun::findOrFail($id);
        if (!hash_equals($pensiun->getRouteHash(), $request->input('hash'))) {
            abort(403, 'URL TIDAK VALID');
        }

        // Otorisasi: Pastikan hanya pegawai yang bersangkutan yang bisa menyimpan
        if (Auth::user()->pegawai->id !== $pensiun->pegawai_id) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
        }

        $berkasFields = Pensiun::$berkasFields;
        $validationRules = [];

        // Membuat aturan validasi dinamis
        foreach ($berkasFields as $field => $label) {
            if ($field === 'berkas_pas_foto') {
                // Pas foto wajib gambar
                $validationRules[$field] = 'required|file|mimes:jpg,png,jpeg|max:1024';
            } elseif ($field === 'berkas_lainnya') {
                // Berkas lainnya tidak wajib dan boleh PDF
                $validationRules[$field] = 'nullable|file|mimes:pdf|max:1024';
            } else {
                // Berkas lainnya wajib PDF
                $validationRules[$field] = 'required|file|mimes:pdf|max:1024';
            }
        }

        $request->validate($validationRules);

        $updateData = [];

        foreach ($berkasFields as $field => $label) {
            if ($request->hasFile($field)) {
                // Hapus file lama jika ada
                if ($pensiun->$field && Storage::disk('public')->exists($pensiun->$field)) {
                    Storage::disk('public')->delete($pensiun->$field);
                }

                // Simpan file baru
                $path = $request->file($field)->store('berkas-pensiun/' . $pensiun->id, 'public');
                $updateData[$field] = $path;
            }
        }

        // Update status dan path berkas di database
        $pensiun->update($updateData);
        $pensiun->status = 'Berkas Lengkap';
        $pensiun->save();

        // Hapus notifikasi terkait setelah berkas diunggah
        Auth::user()->notifications()
            ->where('data->pensiun_id', $pensiun->id)
            ->delete();


        return redirect()->route('dashboard')->with('success', 'Terima kasih! Berkas persyaratan pensiun Anda telah berhasil diunggah.');
    }
}