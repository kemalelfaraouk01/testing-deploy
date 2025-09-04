<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pensiun;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PensiunController extends Controller
{
    public function index()
    {
        $dataPensiun = Pensiun::with('pegawai')->latest()->paginate(10);
        return view('pensiun.index', compact('dataPensiun'));
    }

    public function create()
    {
        // 1. Tentukan usia pensiun dan tahun lahir maksimal
        $usiaPensiun = 58;
        $tahunSekarang = Carbon::now()->year;
        $tahunLahirMaksimal = $tahunSekarang - $usiaPensiun;

        // 2. Ambil ID pegawai yang sudah pernah diusulkan pensiun
        $pensiunPegawaiIds = Pensiun::pluck('pegawai_id')->all();

        // 3. Query pegawai dengan nama kolom yang benar
        $pegawaiRekomendasi = Pegawai::whereIn('status_kepegawaian', ['Aktif', 'PNS'])
            ->whereNotNull('nama_lengkap')      // <-- PERBAIKAN: dari 'nama' menjadi 'nama_lengkap'
            ->where('nama_lengkap', '!=', '')   // <-- PERBAIKAN: dari 'nama' menjadi 'nama_lengkap'
            ->whereYear('tanggal_lahir', '<=', $tahunLahirMaksimal)
            ->whereNotIn('id', $pensiunPegawaiIds)
            ->orderBy('tanggal_lahir', 'asc')
            ->get();

        return view('pensiun.create', compact('pegawaiRekomendasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id|unique:pensiuns,pegawai_id',
            'tanggal_pensiun' => 'required|date',
            'jenis_pensiun' => 'required|string',
        ], [
            'pegawai_id.unique' => 'Pegawai ini sudah pernah diusulkan untuk pensiun.'
        ]);

        $pensiun = Pensiun::create($request->all());

        // Update status pegawai menjadi "Pensiun" setelah diusulkan
        $pegawai = Pegawai::find($request->pegawai_id);
        if ($pegawai) {
            $pegawai->status_kepegawaian = 'Pensiun';
            $pegawai->save();
        }

        return redirect()->route('pensiun.index')
            ->with('success', 'Usulan pensiun untuk ' . $pegawai->nama_lengkap . ' berhasil dibuat.');
    }

    public function edit($id)
    {
        // Memuat relasi bertingkat: pensiun -> pegawai -> user
        $pensiun = Pensiun::with('pegawai.user')->findOrFail($id);

        return view('pensiun.edit', compact('pensiun'));
    }

    public function update(Request $request, Pensiun $pensiun)
    {
        $request->validate([
            'tanggal_pensiun' => 'required|date',
            'jenis_pensiun' => 'required|string',
            'status' => 'required|string',
        ]);

        $pensiun->update($request->all());

        return redirect()->route('pensiun.index')
            ->with('success', 'Data usulan pensiun berhasil diperbarui.');
    }

    public function destroy(Pensiun $pensiun)
    {
        $pensiun->delete();

        return redirect()->route('pensiun.index')
            ->with('success', 'Data usulan pensiun berhasil dihapus.');
    }

    // Method lainnya tidak diubah
}
