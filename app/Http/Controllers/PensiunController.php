<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pensiun;
use App\Notifications\PensiunDiajukanNotification;
use App\Notifications\PensiunPerluPerbaikanNotification;
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

        $pensiun = Pensiun::create([
            'pegawai_id' => $request->pegawai_id,
            'tanggal_pensiun' => $request->tanggal_pensiun,
            'jenis_pensiun' => $request->jenis_pensiun,
            'status' => 'Menunggu Berkas', // Set status awal
        ]);

        // Kirim notifikasi ke pegawai yang bersangkutan
        $pegawai = Pegawai::find($request->pegawai_id);
        if ($pegawai && $pegawai->user) {
            $pegawai->user->notify(new PensiunDiajukanNotification($pensiun));
        }

        return redirect()->route('pensiun.index')
            ->with('success', 'Usulan pensiun untuk ' . $pegawai->nama_lengkap . ' berhasil dibuat. Pegawai telah dinotifikasikan untuk melengkapi berkas.');
    }

    public function edit(Request $request, $id)
    {
        $pensiun = Pensiun::with('pegawai.user')->findOrFail($id);
        if (!hash_equals($pensiun->getRouteHash(), $request->hash)) {
            abort(403, 'URL TIDAK VALID');
        }

        $berkasFields = Pensiun::$berkasFields;
        return view('pensiun.edit', compact('pensiun', 'berkasFields'));
    }

    public function update(Request $request, $id)
    {
        $pensiun = Pensiun::findOrFail($id);
        if (!hash_equals($pensiun->getRouteHash(), $request->input('hash'))) {
            abort(403, 'URL TIDAK VALID');
        }

        $request->validate([
            'tanggal_pensiun' => 'required|date',
            'jenis_pensiun' => 'required|string',
            'status' => 'required|string',
        ]);

        $pensiun->update($request->all());

        return redirect()->route('pensiun.index')
            ->with('success', 'Data usulan pensiun berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $pensiun = Pensiun::findOrFail($id);
        if (!hash_equals($pensiun->getRouteHash(), $request->hash)) {
            abort(403, 'URL TIDAK VALID');
        }

        $pegawai = $pensiun->pegawai;
        $pensiun->delete();

        if ($pegawai) {
            $pegawai->status_kepegawaian = 'PNS';
            $pegawai->save();
        }

        return redirect()->route('pensiun.index')
            ->with('success', 'Data usulan pensiun untuk ' . ($pegawai ? $pegawai->nama_lengkap : '') . ' berhasil dihapus dan status kepegawaiannya telah dikembalikan.');
    }

    public function approve(Request $request, $id)
    {
        $pensiun = Pensiun::findOrFail($id);
        if (!hash_equals($pensiun->getRouteHash(), $request->input('hash'))) {
            abort(403, 'URL TIDAK VALID');
        }

        if ($pensiun->status !== 'Berkas Lengkap') {
            return redirect()->route('pensiun.index')
                ->with('error', 'Hanya usulan dengan status \'Berkas Lengkap\' yang dapat disetujui.');
        }

        $pensiun->status = 'Selesai';
        $pensiun->save();

        $pegawai = $pensiun->pegawai;
        if ($pegawai) {
            $pegawai->status_kepegawaian = 'Pensiun';
            $pegawai->opd_id = null;
            $pegawai->save();
        }

        return redirect()->route('pensiun.index')
            ->with('success', 'Usulan pensiun untuk ' . $pegawai->nama_lengkap . ' telah disetujui dan statusnya diperbarui menjadi Pensiun.');
    }

    public function requestCorrection(Request $request, $id)
    {
        $pensiun = Pensiun::findOrFail($id);
        if (!hash_equals($pensiun->getRouteHash(), $request->input('hash'))) {
            abort(403, 'URL TIDAK VALID');
        }

        $request->validate([
            'catatan_perbaikan' => 'required|string|min:10',
        ]);

        if ($pensiun->status !== 'Berkas Lengkap') {
            return redirect()->route('pensiun.index')->with('error', 'Hanya usulan dengan status "Berkas Lengkap" yang bisa diminta perbaikan.');
        }

        $pensiun->status = 'Perlu Perbaikan';
        $pensiun->catatan_perbaikan = $request->catatan_perbaikan;
        $pensiun->save();

        if ($pensiun->pegawai && $pensiun->pegawai->user) {
            $pensiun->pegawai->user->notify(new PensiunPerluPerbaikanNotification($pensiun));
        }

        return redirect()->route('pensiun.index')->with('success', 'Permintaan perbaikan telah dikirim ke pegawai.');
    }
}
