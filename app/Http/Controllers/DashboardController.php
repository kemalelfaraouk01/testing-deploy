<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Pegawai;
use App\Models\Satyalancana;
use App\Models\Pensiun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $adminRoles = [
            'Admin',
            'Kepala OPD',
            'Kepala Bidang',
<<<<<<< HEAD
            'Operator TPP',
=======
            'Pengelola',
>>>>>>> 82e007e84e5692e3a77758ea4a1d8379eb8fc049
            'Verifikasi TPP',
            'Verif Cuti Kabid',
            'Verif Cuti KaOPD',
            'Pengelola Satyalancana',
            'Pengelola Pensiun'
        ];

        if ($user->hasAnyRole($adminRoles)) {
            $activities = ActivityLog::with(['user', 'subject'])->latest()->take(5)->get();

            $totalPegawai = Pegawai::count();
            $queryCuti = Cuti::where('status', 'disetujui_kaopd')
                ->whereDate('tanggal_mulai', '<=', today())
                ->whereDate('tanggal_selesai', '>=', today());

            if (!$user->hasRole('Admin')) {
                $opd_id = $user->pegawai->opd_id ?? null;
                if ($opd_id) {
                    $queryCuti->whereHas('pegawai', function ($q) use ($opd_id) {
                        $q->where('opd_id', $opd_id);
                    });
                } else {
                    $queryCuti->whereRaw('0=1');
                }
            }
            $jumlahCuti = $queryCuti->count();

            // Ini adalah kode asli Anda untuk grafik golongan, tidak saya ubah.
            $golonganOrder = [
                'I/a',
                'I/b',
                'I/c',
                'I/d',
                'II/a',
                'II/b',
                'II/c',
                'II/d',
                'III/a',
                'III/b',
                'III/c',
                'III/d',
                'IV/a',
                'IV/b',
                'IV/c',
                'IV/d',
                'IV/e'
            ];

            $dataGolongan = Pegawai::select('golongan', DB::raw('count(*) as total'))
                ->whereNotNull('golongan')
                ->where('golongan', '!=', '')
                ->groupBy('golongan')
                ->get();

            $dataGolonganMap = $dataGolongan->keyBy('golongan');

            $chartLabels = [];
            $chartData = [];

            foreach ($golonganOrder as $golongan) {
                if (isset($dataGolonganMap[$golongan])) {
                    $chartLabels[] = $golongan;
                    $chartData[] = $dataGolonganMap[$golongan]->total;
                }
            }

            // Grafik OPD
            $opdData = Pegawai::join('opds', 'pegawais.opd_id', '=', 'opds.id')
                ->select('opds.nama_opd', DB::raw('count(pegawais.id) as total'))
                ->groupBy('opds.nama_opd')->orderBy('total', 'desc')->pluck('total', 'nama_opd');

            $topOpdData = $opdData->take(5);
            $opdChartData = $topOpdData->values();
            $opdChartLabels = $topOpdData->keys();
            $opdLegendLabels = $topOpdData->keys();

            $notifications = $user->unreadNotifications()->take(5)->get();

            // ▼▼▼ PERBAIKAN HANYA DI SINI ▼▼▼
            $tugasSatyalancana = null; // Definisikan variabel agar tidak error

            return view('dashboard', [
                'totalPegawai' => $totalPegawai,
                'jumlahCuti' => $jumlahCuti,
                'chartLabels' => $chartLabels,
                'chartData' => $chartData,
                'opdChartLabels' => $opdChartLabels,
                'opdChartData' => $opdChartData,
                'opdLegendLabels' => $opdLegendLabels,
                'notifications' => $notifications,
                'activities' => $activities,
                'tugasSatyalancana' => $tugasSatyalancana, // Kirim variabel ke view
            ]);
            // ▲▲▲ AKHIR PERBAIKAN ▲▲▲
        }

        // Kode untuk user biasa tidak diubah sama sekali.
        $activities = ActivityLog::with(['user', 'subject'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $pegawaiId = $user->pegawai->id ?? null;
        $tugasPensiun = null;
        $tugasSatyalancana = null;

        if ($pegawaiId) {
            $tugasPensiun = Pensiun::where('pegawai_id', $pegawaiId)
                ->whereIn('status', ['Perlu Perbaikan', 'Menunggu Berkas'])
                ->first();

            $tugasSatyalancana = Satyalancana::where('pegawai_id', $pegawaiId)
                ->whereIn('status', ['menunggu_kelengkapan_berkas', 'perlu_perbaikan'])
                ->first();
        }

        return view('user_dashboard', [
            'tugasPensiun' => $tugasPensiun,
            'tugasSatyalancana' => $tugasSatyalancana,
            'activities' => $activities,
        ]);
    }
}
