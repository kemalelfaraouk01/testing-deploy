<?php

namespace App\Providers;

use App\Models\Satyalancana;
use App\Policies\SatyalancanaPolicy;
use App\Models\PengajuanTpp;
use App\Policies\PengajuanTppPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Satyalancana::class => SatyalancanaPolicy::class,
        PengajuanTpp::class => PengajuanTppPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
