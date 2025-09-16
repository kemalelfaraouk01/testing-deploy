<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Pagination\Paginator; // <-- Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind(); // <-- Tambahkan ini

        Gate::define('access-satyalancana-verification', function (User $user) {
            // Izinkan jika user adalah Admin
            if ($user->hasRole('Admin')) {
                return true;
            }
            // Izinkan jika user adalah Kepala Bidang DAN dari OPD BKPSDM
            return $user->hasRole('Kepala Bidang') &&
                $user->pegawai?->opd?->nama_opd === 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia';
        });
    }
}
