<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\RiwayatJabatan;
use Illuminate\Http\Request;

class RiwayatJabatanController extends Controller
{

    /**
     * Menyimpan data riwayat jabatan baru.
     */
    public function store(Request $request, Pegawai $pegawai)
    {
        $validatedData = $request->validate([
            'jabatan' => 'required|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'jenis_jabatan' => 'required|string',
            'tmt_jabatan' => 'required|date',
            'nomor_sk' => 'required|string|max:255',
            'tanggal_sk' => 'required|date',
        ]);

        $pegawai->riwayatJabatans()->create($validatedData);

        return redirect()->route('pegawai.show', $pegawai->id)
            ->with('success', 'Data riwayat jabatan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit riwayat jabatan.
     */
    public function edit(RiwayatJabatan $riwayatJabatan)
    {
        return view('riwayat-jabatan.edit', compact('riwayatJabatan'));
    }

    /**
     * Mengupdate data riwayat jabatan.
     */
    public function update(Request $request, RiwayatJabatan $riwayatJabatan)
    {
        $validatedData = $request->validate([
            'jabatan' => 'required|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'jenis_jabatan' => 'required|string',
            'tmt_jabatan' => 'required|date',
            'nomor_sk' => 'required|string|max:255',
            'tanggal_sk' => 'required|date',
        ]);

        $riwayatJabatan->update($validatedData);

        return redirect()->route('pegawai.show', $riwayatJabatan->pegawai_id)
            ->with('success', 'Data riwayat jabatan berhasil diperbarui.');
    }

    /**
     * Menghapus data riwayat jabatan.
     */
    public function destroy(RiwayatJabatan $riwayatJabatan)
    {
        $pegawaiId = $riwayatJabatan->pegawai_id;
        $riwayatJabatan->delete();

        return redirect()->route('pegawai.show', $pegawaiId)
            ->with('success', 'Data riwayat jabatan berhasil dihapus.');
    }

    /**
     * Menampilkan form untuk membuat riwayat jabatan baru.
     */
    public function create(Pegawai $pegawai)
    {
        return view('riwayat-jabatan.create', compact('pegawai'));
    }
}
