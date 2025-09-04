<?php

namespace App\Http\Controllers;

use App\Models\Opd; // Import
use App\Models\Pegawai;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $opds = collect();
        $userOpd = null;

        if ($user->hasRole('Admin')) {
            // Admin bisa memilih semua OPD
            $opds = Opd::orderBy('nama_opd')->get();
        } else {
            // Peran lain otomatis terpilih OPD-nya
            $userOpd = $user->pegawai->opd ?? null;
        }

        return view('laporan.index', compact('opds', 'userOpd'));
    }



    public function cetakDuk(Request $request)
    {
        $validated = $request->validate([
            'opd_id' => 'required|exists:opds,id',
            'type' => 'required|in:pdf,excel',
        ]);

        $opd = Opd::findOrFail($validated['opd_id']);
        $pegawais = Pegawai::with('user')->where('opd_id', $validated['opd_id'])->get();

        $educationSortOrder = [
            'S3' => 1,
            'S2' => 2,
            'S1' => 3,
            'D4' => 4,
            'D3' => 5,
            'D2' => 6,
            'D1' => 7,
            'SMA' => 8,
            'SMP' => 9,
            'SD' => 10,
        ];

        // ==========================================================
        // BAGIAN YANG DISESUAIKAN: Urutan sorting diperbaiki
        // ==========================================================
        $sortedPegawais = $pegawais->sortBy(
            [
                // Kriteria 1 (UTAMA): Pangkat/Golongan (Tertinggi ke Terendah)
                ['urutan_pangkat', 'asc'], // Angka kecil lebih tinggi

                // Kriteria 2: TMT Pangkat (Paling Lama)
                ['tmt_pangkat', 'asc'],

                // Kriteria 3: TMT Jabatan (Paling Lama)
                ['tmt_jabatan', 'asc'],

                // Kriteria 4: Usia (Tua ke Muda)
                ['tanggal_lahir', 'asc'],

                // Kriteria 5: Pendidikan (Tinggi ke Rendah)
                function ($p) use ($educationSortOrder) {
                    return $educationSortOrder[$p->pendidikan_terakhir] ?? 999;
                },

                // Kriteria 6 (terakhir): NIP (Lama ke Baru)
                fn($p) => $p->user->nip,
            ]
        );

        if ($validated['type'] === 'pdf') {
            $pdf = Pdf::loadView('pdf.duk', [
                'pegawais' => $sortedPegawais,
                'opd' => $opd,
                'tanggalCetak' => now()->translatedFormat('d F Y')
            ]);

            return $pdf->setPaper('a4', 'landscape')->stream('laporan-duk-' . $opd->kode_opd . '.pdf');
        }
    }

    public function cetakRekapitulasiJabatan(Request $request)
    {
        $validated = $request->validate(['opd_id' => 'required|exists:opds,id']);
        $opd = Opd::findOrFail($validated['opd_id']);

        // 1. Hitung jumlah Laki-laki & Perempuan (tidak berubah)
        $genderCounts = Pegawai::where('opd_id', $opd->id)
            ->select('jenis_kelamin', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')
            ->pluck('total', 'jenis_kelamin');

        // ==========================================================
        // BAGIAN YANG DISESUAIKAN: Logika penghitungan eselon
        // ==========================================================
        $eselonCounts = Pegawai::where('opd_id', $opd->id)
            // Dibuat tidak case-sensitive: mencari 'struktural' tidak peduli huruf besar/kecil
            ->whereRaw('LOWER(jenis_jabatan) = ?', ['struktural'])
            ->select(
                // Menggunakan CASE untuk mencocokkan berbagai format golongan
                DB::raw("CASE 
                        WHEN golongan LIKE 'II/a%' THEN 'II/a'
                        WHEN golongan LIKE 'II/b%' THEN 'II/b'
                        WHEN golongan LIKE 'III/a%' THEN 'III/a'
                        WHEN golongan LIKE 'III/b%' THEN 'III/b'
                        WHEN golongan LIKE 'IV/a%' THEN 'IV/a'
                        WHEN golongan LIKE 'IV/b%' THEN 'IV/b'
                        ELSE 'Lainnya'
                     END as eselon_group"),
                DB::raw('count(*) as total')
            )
            ->groupBy('eselon_group')
            ->pluck('total', 'eselon_group');

        // Siapkan data untuk view
        $data = [
            'opd' => $opd,
            'jumlah_lk' => $genderCounts->get('L', 0),
            'jumlah_pr' => $genderCounts->get('P', 0),
            'eselon_2a' => $eselonCounts->get('II/a', 0),
            'eselon_2b' => $eselonCounts->get('II/b', 0),
            'eselon_3a' => $eselonCounts->get('III/a', 0),
            'eselon_3b' => $eselonCounts->get('III/b', 0),
            'eselon_4a' => $eselonCounts->get('IV/a', 0),
            'eselon_4b' => $eselonCounts->get('IV/b', 0),
            'tanggalCetak' => now()->translatedFormat('d F Y'),
        ];

        $pdf = Pdf::loadView('pdf.rekapitulasi-jabatan', $data);
        return $pdf->stream('rekapitulasi-jabatan-' . $opd->kode_opd . '.pdf');
    }

    /**
     * Membuat dan mencetak laporan pegawai yang akan pensiun.
     */
    public function cetakPensiun(Request $request)
    {
        $validated = $request->validate([
            'rentang_waktu' => 'required|integer|in:1,2,5',
        ]);

        // Ubah rentangTahun menjadi integer secara eksplisit
        $rentangTahun = (int) $validated['rentang_waktu'];

        // Sekarang $rentangTahun dijamin berupa angka
        $batasWaktu = now()->addYears($rentangTahun);

        // Asumsi usia pensiun adalah 58 tahun
        $usiaPensiun = 58;

        // Ambil semua pegawai aktif yang memiliki tanggal lahir
        $pegawais = Pegawai::where('status_kepegawaian', 'PNS')
            ->whereNotNull('tanggal_lahir')
            ->get();

        $pegawaiAkanPensiun = $pegawais->filter(function ($pegawai) use ($usiaPensiun, $batasWaktu) {
            $tanggalLahir = Carbon::parse($pegawai->tanggal_lahir);

            // Hitung TMT Pensiun: 1 bulan setelah ulang tahun ke-58
            $tmtPensiun = $tanggalLahir->addYears($usiaPensiun)->addMonth()->startOfMonth();

            // Cek apakah TMT Pensiun masuk dalam rentang waktu yang dipilih
            return $tmtPensiun->isBefore($batasWaktu) && $tmtPensiun->isFuture();
        })->sortBy(function ($pegawai) use ($usiaPensiun) {
            // Urutkan berdasarkan tanggal pensiun terdekat
            return Carbon::parse($pegawai->tanggal_lahir)->addYears($usiaPensiun);
        });

        $pdf = Pdf::loadView('pdf.pensiun', [
            'pegawais' => $pegawaiAkanPensiun,
            'rentangTahun' => $rentangTahun,
            'usiaPensiun' => $usiaPensiun,
            'tanggalCetak' => now()->translatedFormat('d F Y')
        ]);

        return $pdf->setPaper('a4', 'portrait')->stream('laporan-pegawai-akan-pensiun.pdf');
    }
}
