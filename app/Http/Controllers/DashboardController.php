<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Pegawai;
use App\Models\Satyalancana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dasbor yang sesuai dengan peran pengguna.
     */
    public function index(): View
    {
        $user = Auth::user();

        $activities = ActivityLog::with(['user', 'subject'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        if ($user->hasRole('User')) {
            return view('user_dashboard', compact('activities'));
        }

        // --- DATA UNTUK KARTU ---
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
                $queryCuti->whereRaw('0 = 1');
            }
        }
        $jumlahCuti = $queryCuti->count();

        // --- DATA UNTUK CHART GOLONGAN ---
        $golonganData = Pegawai::query()
            ->select(
                DB::raw("
                    CASE
                        WHEN UPPER(golongan) LIKE 'I/%' THEN 'Golongan I'
                        WHEN UPPER(golongan) LIKE 'II/%' THEN 'Golongan II'
                        WHEN UPPER(golongan) LIKE 'III/%' THEN 'Golongan III'
                        WHEN UPPER(golongan) LIKE 'IV/%' THEN 'Golongan IV'
                        ELSE 'Lainnya'
                    END as golongan_grup
                "),
                DB::raw('count(*) as total')
            )
            ->whereNotNull('golongan')
            ->where('golongan', '!=', '')
            ->groupBy('golongan_grup')
            ->orderBy('golongan_grup')
            ->pluck('total', 'golongan_grup');

        $chartLabels = $golonganData->keys();
        $chartData = $golonganData->values();

        // === PERUBAHAN DI BAGIAN DATA CHART OPD ===
        $opdData = Pegawai::join('opds', 'pegawais.opd_id', '=', 'opds.id')
            ->select('opds.nama_opd', DB::raw('count(pegawais.id) as total'))
            ->groupBy('opds.nama_opd')
            ->orderBy('total', 'desc')
            ->pluck('total', 'nama_opd');

        // Data lengkap untuk chart
        $opdChartLabels = $opdData->keys();
        $opdChartData = $opdData->values();

        // Data teratas (top 5) khusus untuk legenda
        $topOpdData = $opdData->take(5);
        $opdLegendLabels = $topOpdData->keys();
        // ==========================================

        // --- Notifikasi ---
        $notifications = $user->unreadNotifications()->take(5)->get();

        $tugasSatyalancana = null;
        if ($user->pegawai) {
            $tugasSatyalancana = Satyalancana::where('pegawai_id', $user->pegawai->id)
                ->where('status', 'menunggu_kelengkapan_berkas')
                ->first();
        }

        return view('dashboard', [
            'totalPegawai' => $totalPegawai,
            'jumlahCuti' => $jumlahCuti,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'opdChartLabels' => $opdChartLabels,
            'opdChartData' => $opdChartData,
            'opdLegendLabels' => $opdLegendLabels, // Kirim data legenda ke view
            'notifications' => $notifications,
            'tugasSatyalancana' => $tugasSatyalancana,
            'activities' => $activities,
        ]);
    }
}
