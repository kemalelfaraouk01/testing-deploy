<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\RiwayatPangkat;
use Illuminate\Http\Request;

class RiwayatPangkatController extends Controller
{
    /**
     * Menyimpan data riwayat pangkat baru.
     */
    public function store(Request $request, Pegawai $pegawai)
    {
        $validatedData = $request->validate([
            'pangkat' => 'required|string|max:255',
            'golongan' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'tmt_pangkat' => 'required|date',
            'nomor_sk' => 'required|string|max:255',
            'tanggal_sk' => 'required|date',
        ]);

        // Gunakan relasi untuk membuat data baru, pegawai_id akan terisi otomatis
        $pegawai->riwayatPangkats()->create($validatedData);

        return redirect()->route('pegawai.show', $pegawai->id)
            ->with('success', 'Data riwayat pangkat berhasil ditambahkan.');
    }

    public function create(Pegawai $pegawai)
    {
        return view('riwayat-pangkat.create', compact('pegawai'));
    }

    /**
     * Menampilkan form untuk mengedit riwayat pangkat.
     */
    public function edit(RiwayatPangkat $riwayatPangkat)
    {
        return view('riwayat-pangkat.edit', compact('riwayatPangkat'));
    }

    /**
     * Mengupdate data riwayat pangkat.
     */
    public function update(Request $request, RiwayatPangkat $riwayatPangkat)
    {
        $validatedData = $request->validate([
            'pangkat' => 'required|string|max:255',
            'golongan' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'tmt_pangkat' => 'required|date',
            'nomor_sk' => 'required|string|max:255',
            'tanggal_sk' => 'required|date',
        ]);

        $riwayatPangkat->update($validatedData);

        return redirect()->route('pegawai.show', $riwayatPangkat->pegawai_id)
            ->with('success', 'Data riwayat pangkat berhasil diperbarui.');
    }

    public function destroy(RiwayatPangkat $riwayatPangkat)
    {
        // Simpan dulu ID pegawai sebelum data dihapus
        $pegawaiId = $riwayatPangkat->pegawai_id;

        $riwayatPangkat->delete();

        return redirect()->route('pegawai.show', $pegawaiId)
            ->with('success', 'Data riwayat pangkat berhasil dihapus.');
    }
}
