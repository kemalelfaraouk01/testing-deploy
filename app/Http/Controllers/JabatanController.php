<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Menampilkan daftar semua jabatan.
     */
    public function index()
    {
        $jabatans = Jabatan::latest()->paginate(15);
        return view('pengaturan.jabatan.index', compact('jabatans'));
    }

    /**
     * Menampilkan form untuk membuat jabatan baru.
     */
    public function create()
    {
        return view('pengaturan.jabatan.create');
    }

    /**
     * Menyimpan jabatan baru ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatans,nama_jabatan',
        ]);

        Jabatan::create($request->all());

        return redirect()->route('jabatan.index')
            ->with('success', 'Data jabatan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data jabatan.
     */
    public function edit(Jabatan $jabatan)
    {
        return view('pengaturan.jabatan.edit', compact('jabatan'));
    }

    /**
     * Memperbarui data jabatan di dalam database.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatans,nama_jabatan,' . $jabatan->id,
        ]);

        $jabatan->update($request->all());

        return redirect()->route('jabatan.index')
            ->with('success', 'Data jabatan berhasil diperbarui.');
    }

    /**
     * Menghapus data jabatan dari database.
     */
    public function destroy(Jabatan $jabatan)
    {
        // Pengecekan apakah jabatan masih digunakan oleh pegawai
        // Catatan: Ini memerlukan perubahan pada tabel 'pegawais' untuk menyimpan 'jabatan_id'
        // Untuk saat ini, kita izinkan penghapusan langsung.

        $jabatan->delete();

        return redirect()->route('jabatan.index')
            ->with('success', 'Data jabatan berhasil dihapus.');
    }
}
