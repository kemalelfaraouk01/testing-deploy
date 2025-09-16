<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\Opd;
use App\Models\Jabatan; // <-- Penambahan import
use Illuminate\Validation\Rule; // <-- Tambahkan ini
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PegawaiImport;
use Maatwebsite\Excel\Validators\ValidationException;


class PegawaiController extends Controller
{
    /**
     * Menampilkan daftar data pegawai.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Pegawai::with('user')->where(function ($q) {
            $q->where('status_kepegawaian', '!=', 'Pensiun')
                ->orWhereNull('status_kepegawaian');
        })->latest();
        $namaOpd = 'Semua OPD'; // Default
        $opds = collect(); // Default ke koleksi kosong
        $selectedOpdId = $request->input('opd_id');
        $searchNama = $request->input('search_nama');
        $searchStatus = $request->input('status_kepegawaian'); // Ambil status dari request

        // Terapkan filter pencarian nama jika ada
        if ($searchNama) {
            $query->where('nama_lengkap', 'like', '%' . $searchNama . '%');
        }

        // Terapkan filter status jika ada
        if ($searchStatus) {
            $query->where('status_kepegawaian', $searchStatus);
        }

        if ($user->hasRole('Admin')) {
            $opds = Opd::orderBy('nama_opd')->get();

            if ($selectedOpdId) {
                $query->where('opd_id', $selectedOpdId);
                $filteredOpd = $opds->find($selectedOpdId);
                $namaOpd = $filteredOpd ? $filteredOpd->nama_opd : 'OPD Tidak Ditemukan';
            }
        } else {
            // Logika yang sudah ada untuk non-admin
            $opd_id = $user->pegawai->opd_id ?? null;

            if ($opd_id) {
                $query->where('opd_id', $opd_id);
                $namaOpd = $user->pegawai->opd->nama_opd;
            } else {
                $query->whereRaw('0 = 1');
                $namaOpd = 'Tidak Terikat OPD';
            }
        }

        $pegawais = $query->paginate(10)->withQueryString();
        $statuses = Pegawai::$selectable_statuses; // Ambil daftar status

        return view('pegawai.index', compact('pegawais', 'namaOpd', 'opds', 'selectedOpdId', 'searchNama', 'statuses', 'searchStatus'));
    }

    public function show(Pegawai $pegawai)
    {
        $pegawai->load('riwayatPangkats', 'riwayatJabatans');
        return view('pegawai.show', compact('pegawai'));
    }

    /**
     * Menampilkan form untuk membuat data pegawai baru.
     */
    public function create()
    {
        $opds = Opd::all();
        $jabatans = Jabatan::orderBy('nama_jabatan')->get(); // <-- AMBIL DATA JABATAN
        $users = User::whereDoesntHave('pegawai')->get();
        $statuses = Pegawai::$selectable_statuses; // Ambil status dari model
        return view('pegawai.create', compact('opds', 'jabatans', 'users', 'statuses')); // <-- KIRIM KE VIEW
    }


    /**
     * Menyimpan data pegawai baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi semua input dari form
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id|unique:pegawais,user_id',
            'opd_id' => 'nullable|exists:opds,id',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|string|max:255',
            'status_perkawinan' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi untuk upload gambar

            // Data Kepegawaian
            'jabatan' => 'nullable|string|max:255',
            'jenis_jabatan' => 'nullable|string|max:255',
            'pangkat' => 'nullable|string|max:255',
            'golongan' => 'nullable|string|max:255',
            'unit_kerja' => 'nullable|string|max:255',
            'status_kepegawaian' => ['nullable', Rule::in(Pegawai::$selectable_statuses)],
            'jenis_kepegawaian' => 'nullable|string|max:255',
            'tmt_cpns' => 'nullable|date',
            'tmt_pns' => 'nullable|date',
            'tmt_jabatan' => 'nullable|date',
            'nomor_sk_cpns' => 'nullable|string|max:255',
            'nomor_sk_pns' => 'nullable|string|max:255',

            // Data Pendidikan
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'asal_sekolah' => 'nullable|string|max:255',
            'tahun_lulus' => 'nullable|digits:4',

            // Data Tambahan
            'npwp' => 'nullable|string|max:255',
            'bpjs_kesehatan' => 'nullable|string|max:255',
            'bpjs_ketenagakerjaan' => 'nullable|string|max:255',
            'rekening_bank' => 'nullable|string|max:255',
            'nama_bank' => 'nullable|string|max:255',
        ]);

        // Logika untuk menangani upload foto
        if ($request->hasFile('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('pegawai-fotos', 'public');
        }

        // Buat data pegawai baru
        Pegawai::create($validatedData);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data pegawai.
     */
    public function edit(Pegawai $pegawai)
    {
        $opds = Opd::all();
        $jabatans = Jabatan::orderBy('nama_jabatan')->get();
        $statuses = Pegawai::$selectable_statuses; // Ambil status dari model
        return view('pegawai.edit', compact('pegawai', 'opds', 'jabatans', 'statuses')); // <-- KIRIM KE VIEW
    }

    /**
     * Mengupdate data pegawai di database.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        // Validasi input
        $validatedData = $request->validate([
            // Validasi sama seperti 'store', tapi 'user_id' tidak diubah
            'nama_lengkap' => 'required|string|max:255',
            'opd_id' => 'nullable|exists:opds,id',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|string|max:255',
            'status_perkawinan' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi untuk upload gambar

            // Data Kepegawaian
            'jabatan' => 'nullable|string|max:255',
            'jenis_jabatan' => 'nullable|string|max:255',
            'pangkat' => 'nullable|string|max:255',
            'golongan' => 'nullable|string|max:255',
            'unit_kerja' => 'nullable|string|max:255',
            'status_kepegawaian' => ['nullable', Rule::in(Pegawai::$selectable_statuses)],
            'jenis_kepegawaian' => 'nullable|string|max:255',
            'tmt_cpns' => 'nullable|date',
            'tmt_pns' => 'nullable|date',
            'tmt_jabatan' => 'nullable|date',
            'nomor_sk_cpns' => 'nullable|string|max:255',
            'nomor_sk_pns' => 'nullable|string|max:255',

            // Data Pendidikan
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'asal_sekolah' => 'nullable|string|max:255',
            'tahun_lulus' => 'nullable|digits:4',

            // Data Tambahan
            'npwp' => 'nullable|string|max:255',
            'bpjs_kesehatan' => 'nullable|string|max:255',
            'bpjs_ketenagakerjaan' => 'nullable|string|max:255',
            'rekening_bank' => 'nullable|string|max:255',
            'nama_bank' => 'nullable|string|max:255',
            // ... tambahkan validasi lain ...
        ]);

        // Logika untuk menangani upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pegawai->foto) {
                Storage::disk('public')->delete($pegawai->foto);
            }
            // Simpan foto baru
            $validatedData['foto'] = $request->file('foto')->store('pegawai-fotos', 'public');
        }

        // Update data pegawai dengan data yang sudah divalidasi
        $pegawai->update($validatedData);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        // Hapus foto dari storage sebelum menghapus data dari database
        if ($pegawai->foto) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }

    public function destroyAll()
    {
        // Ambil semua pegawai yang user-nya TIDAK memiliki peran 'Admin'
        $pegawaisToDelete = Pegawai::whereHas('user', function ($query) {
            $query->whereDoesntHave('roles', function ($subQuery) {
                $subQuery->where('name', 'Admin');
            });
        })->get();

        if ($pegawaisToDelete->isEmpty()) {
            return redirect()->route('pegawai.index')->with('error', 'Tidak ada data pegawai yang bisa dihapus.');
        }

        foreach ($pegawaisToDelete as $pegawai) {
            // Hapus foto jika ada
            if ($pegawai->foto) {
                Storage::disk('public')->delete($pegawai->foto);
            }
            // Hapus akun user yang terhubung
            $pegawai->user()->delete();
            // Hapus profil pegawai
            $pegawai->delete();
        }

        return redirect()->route('pegawai.index')->with('success', 'Semua data pegawai (kecuali Admin) telah berhasil dihapus.');
    }

    public function showImportForm()
    {
        return view('pegawai.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            // === PERUBAHAN DI SINI ===
            Excel::queueImport(new PegawaiImport, $request->file('file'));
            // =========================
        } catch (ValidationException $e) {
            return back()->with('import_errors', $e->failures());
        }

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai sedang diimpor di background. Proses akan berjalan beberapa saat.');
    }

    /**
     * Menampilkan daftar pegawai yang sudah pensiun.
     */
    public function indexPensiun(Request $request)
    {
        $query = Pegawai::with(['user', 'pensiun'])->where('status_kepegawaian', 'Pensiun')->latest();

        $searchNama = $request->input('search_nama');
        if ($searchNama) {
            $query->where('nama_lengkap', 'like', '%' . $searchNama . '%');
        }

        $pegawais = $query->paginate(10)->withQueryString();

        return view('pegawai.pensiun', compact('pegawais', 'searchNama'));
    }
}
