<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; // <-- Tambahkan import
use App\Imports\OpdImport;             // <-- Tambahkan import
use Maatwebsite\Excel\Validators\ValidationException;

class OpdController extends Controller
{
    /**
     * Menampilkan daftar semua OPD.
     */
    public function index(Request $request) // Tambahkan Request
    {
        $search = $request->input('search');

        $opds = Opd::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_opd', 'like', "%{$search}%")
                    ->orWhere('kode_opd', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // Agar paginasi tetap membawa query pencarian

        return view('pengaturan.opd.index', compact('opds', 'search'));
    }

    /**
     * Menampilkan form untuk membuat OPD baru.
     */
    public function create()
    {
        return view('pengaturan.opd.create');
    }

    /**
     * Menyimpan OPD baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi kode_opd dihapus dari sini
        $validatedData = $request->validate([
            'nama_opd' => 'required|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        // Buat OPD baru tanpa kode_opd terlebih dahulu
        $opd = Opd::create($validatedData);

        // Buat kode_opd secara otomatis berdasarkan ID
        // Contoh format: OPD-001, OPD-002, dst.
        $opd->kode_opd = 'OPD-' . str_pad($opd->id, 3, '0', STR_PAD_LEFT);
        $opd->save();

        return redirect()->route('opd.index')
            ->with('success', 'Data OPD berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data OPD.
     */
    public function edit(Opd $opd)
    {
        return view('pengaturan.opd.edit', compact('opd'));
    }

    /**
     * Memperbarui data OPD di dalam database.
     */
    public function update(Request $request, Opd $opd)
    {
        // Validasi kode_opd juga dihapus dari sini
        $request->validate([
            'nama_opd' => 'required|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        $opd->update($request->all());

        return redirect()->route('opd.index')
            ->with('success', 'Data OPD berhasil diperbarui.');
    }

    /**
     * Menghapus data OPD dari database.
     */
    public function destroy(Opd $opd)
    {
        if ($opd->pegawais()->count() > 0) {
            return redirect()->route('opd.index')
                ->with('error', 'OPD tidak dapat dihapus karena masih memiliki data pegawai terkait.');
        }

        $opd->delete();

        return redirect()->route('opd.index')
            ->with('success', 'Data OPD berhasil dihapus.');
    }

    public function showImportForm()
    {
        return view('pengaturan.opd.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new OpdImport, $request->file('file'));
        } catch (ValidationException $e) {
            // Jika terjadi error validasi di dalam Excel, kirim kembali ke form
            return back()->with('import_errors', $e->failures());
        }

        return redirect()->route('opd.index')->with('success', 'Data OPD berhasil diimpor.');
    }
}
