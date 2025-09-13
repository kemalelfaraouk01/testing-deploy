<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Pegawai; // Pastikan model ini di-import jika digunakan di masa depan
use App\Models\PengajuanTpp;
use App\Models\User;
use App\Notifications\TppDiajukanNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View; // Import View untuk type-hinting
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PengajuanTppController extends Controller
{
    // Definisikan daftar bulan sebagai properti agar bisa dipakai ulang
    private $daftarBulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    public function index(Request $request): View
    {
        $user = Auth::user();
        $opds = collect();

        // === PERBAIKAN QUERY DI SINI ===
        // Mulai query dengan memastikan relasi opd ada
        $query = PengajuanTpp::whereHas('opd');

        if ($user->hasRole('Admin')) {
            $opds = Opd::orderBy('nama_opd')->get();
        } elseif ($user->hasRole('Pengelola')) {
            if ($user->pegawai && $user->pegawai->opd_id) {
                $opds = Opd::where('id', $user->pegawai->opd_id)->get();
                $query->where('opd_id', $user->pegawai->opd_id);
            } else {
                $query->whereRaw('0 = 1');
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('opd_id')) {
            $query->where('opd_id', $request->opd_id);
        }

        $daftarTahun = range(date('Y'), date('Y') - 5);
        $daftarStatus = ['draft', 'diajukan', 'disetujui', 'ditolak', 'perlu_perbaikan'];

        $pengajuanTpps = $query->with('opd')->latest()->paginate(10)->withQueryString();

        return view('pengajuan-tpp.index', [
            'opds' => $opds,
            'daftarBulan' => $this->daftarBulan,
            'daftarTahun' => $daftarTahun,
            'daftarStatus' => $daftarStatus,
            'pengajuanTpps' => $pengajuanTpps,
        ]);
    }

    public function lanjutkanKeForm(Request $request)
    {
        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer',
            'opd_id' => 'required|exists:opds,id',
        ]);

        // === PENAMBAHAN VALIDASI PENCEGAHAN DUPLIKAT ===
        $existingPengajuan = PengajuanTpp::where('periode_bulan', $validated['bulan'])
            ->where('periode_tahun', $validated['tahun'])
            ->where('opd_id', $validated['opd_id'])
            ->first();

        if ($existingPengajuan) {
            return redirect()->route('pengajuan-tpp.index')
                ->with('error', 'Pengajuan TPP untuk periode dan OPD tersebut sudah pernah dibuat sebelumnya.');
        }
        // ===============================================

        $bulan = $validated['bulan'];
        $tahun = $validated['tahun'];
        $opd_id = $validated['opd_id'];

        $stringToHash = "{$bulan}-{$tahun}-{$opd_id}";
        $hash = hash_hmac('sha256', $stringToHash, config('app.key'));

        return redirect()->route('pengajuan-tpp.create', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'opd_id' => $opd_id,
            'hash' => $hash
        ]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer',
            'opd_id' => 'required|exists:opds,id',
            'hash' => 'required|string',
        ]);

        $stringToHash = "{$validated['bulan']}-{$validated['tahun']}-{$validated['opd_id']}";
        $expectedHash = hash_hmac('sha256', $stringToHash, config('app.key'));

        if (!hash_equals($expectedHash, $validated['hash'])) {
            abort(403, 'URL TIDAK VALID: Tanda tangan digital tidak cocok.');
        }

        $user = Auth::user();
        if ($user->hasRole('Pengelola')) {
            $opdIdPengelola = $user->pegawai->opd_id ?? null;
            if ($opdIdPengelola != $validated['opd_id']) {
                abort(403, 'AKSES DITOLAK: Anda tidak berwenang mengajukan TPP untuk OPD ini.');
            }
        }

        $opd = Opd::findOrFail($validated['opd_id']);
        $namaBulan = $this->daftarBulan[$validated['bulan']];

        return view('pengajuan-tpp.create', [
            'bulan' => $validated['bulan'],
            'tahun' => $validated['tahun'],
            'opd' => $opd,
            'namaBulan' => $namaBulan,
        ]);
    }

    // app/Http/Controllers/PengajuanTppController.php

    public function store(Request $request)
    {
        // === PERUBAHAN VALIDASI FILE DI SINI ===
        $validatedData = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2100',
            'opd_id' => 'required|exists:opds,id',
            'berkas_tpp' => 'required|file|mimes:pdf|max:1024',
            'berkas_spj' => 'required|file|mimes:pdf|max:1024',
            'berkas_pernyataan' => 'required|file|mimes:pdf|max:1024',
            'berkas_pengantar' => 'required|file|mimes:pdf|max:1024',
        ]);
        // =======================================

        $user = Auth::user();
        $dataToCreate = $validatedData;

        if ($user->hasRole('Pengelola')) {
            $dataToCreate['opd_id'] = optional($user->pegawai)->opd_id;
        }

        $paths = [];
        $fileFields = ['berkas_tpp', 'berkas_spj', 'berkas_pernyataan', 'berkas_pengantar'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $paths[$field] = $request->file($field)->store('berkas-tpp', 'public');
            }
        }

        $pengajuan = PengajuanTpp::create([
            'periode_bulan' => $dataToCreate['bulan'],
            'periode_tahun' => $dataToCreate['tahun'],
            'opd_id' => $dataToCreate['opd_id'],
            'besaran_tpp_diajukan' => 0,
            'status' => 'diajukan',
            'berkas_tpp' => $paths['berkas_tpp'] ?? null,
            'berkas_spj' => $paths['berkas_spj'] ?? null,
            'berkas_pernyataan' => $paths['berkas_pernyataan'] ?? null,
            'berkas_pengantar' => $paths['berkas_pengantar'] ?? null,
        ]);

        $verifikator = User::role(['Admin', 'Verifikasi TPP'])->get();
        Notification::send($verifikator, new TppDiajukanNotification($pengajuan));

        return redirect()->route('pengajuan-tpp.index')
            ->with('success', 'Berkas TPP berhasil diajukan.');
    }

    public function show(Request $request, PengajuanTpp $pengajuanTpp)
    {
        if (!hash_equals($pengajuanTpp->getRouteHash(), $request->hash)) {
            abort(403, 'URL TIDAK VALID.');
        }

        // Eager load relasi OPD untuk memastikan data tersedia di view
        $pengajuanTpp->load('opd');
        $namaOpd = $pengajuanTpp->opd ? $pengajuanTpp->opd->nama_opd : '[OPD tidak ditemukan]';

        return view('pengajuan-tpp.show', [
            'pengajuanTpp' => $pengajuanTpp,
            'daftarBulan' => $this->daftarBulan,
            'namaOpd' => $namaOpd
        ]);
    }

    public function cetak(PengajuanTpp $pengajuanTpp)
    {
        if ($pengajuanTpp->status !== 'disetujui') {
            abort(403, 'Dokumen ini tidak dapat dicetak karena belum disetujui.');
        }
        $kepalaBkpsdm = User::whereHas('roles', fn($q) => $q->where('name', 'Kepala OPD'))
            ->whereHas('pegawai.opd', fn($q) => $q->where('nama_opd', 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia'))
            ->first();

        $pdf = Pdf::loadView('pdf.surat-tpp', [
            'pengajuan' => $pengajuanTpp,
            'namaBulan' => $this->daftarBulan[$pengajuanTpp->periode_bulan],
            'kepalaBkpsdm' => $kepalaBkpsdm
        ]);

        return $pdf->stream('bukti-persetujuan-tpp-' . $pengajuanTpp->id . '.pdf');
    }

    public function edit(Request $request, PengajuanTpp $pengajuanTpp)
    {
        if (!hash_equals($pengajuanTpp->getRouteHash(), $request->hash)) {
            abort(403, 'URL TIDAK VALID.');
        }

        if ($pengajuanTpp->status !== 'perlu_perbaikan') {
            abort(403, 'Halaman ini tidak bisa diakses.');
        }

        return view('pengajuan-tpp.edit', [
            'pengajuanTpp' => $pengajuanTpp,
            'daftarBulan' => $this->daftarBulan
        ]);
    }

    public function update(Request $request, PengajuanTpp $pengajuanTpp)
    {
        // === PERUBAHAN VALIDASI FILE DI SINI ===
        $validatedData = $request->validate([
            'berkas_tpp.*' => 'nullable|file|mimes:pdf|max:1024',
            'berkas_spj.*' => 'nullable|file|mimes:pdf|max:1024',
            'berkas_pernyataan.*' => 'nullable|file|mimes:pdf|max:1024',
            'berkas_pengantar.*' => 'nullable|file|mimes:pdf|max:1024',
        ]);
        // =======================================

        $fileFields = ['berkas_tpp', 'berkas_spj', 'berkas_pernyataan', 'berkas_pengantar'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field)[0];

                if ($file->isValid()) {
                    if ($pengajuanTpp->$field) {
                        Storage::disk('public')->delete($pengajuanTpp->$field);
                    }
                    $pengajuanTpp->$field = $file->store('berkas-tpp', 'public');
                }
            }
        }

        $pengajuanTpp->status = 'diajukan';
        $pengajuanTpp->keterangan = null;
        $pengajuanTpp->save();

        $verifikator = User::role(['Admin', 'Verifikasi TPP'])->get();
        Notification::send($verifikator, new TppDiajukanNotification($pengajuanTpp));

        return redirect()->route('pengajuan-tpp.index')
            ->with('success', 'Berkas perbaikan TPP telah berhasil dikirim kembali.');
    }
}
