<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $notifications = $user->notifications()->latest()->take(5)->get();
                $unreadNotificationsCount = $user->unreadNotifications()->count();

                $view->with([
                    'notificationsForLayout' => $notifications,
                    'unreadNotificationsCountForLayout' => $unreadNotificationsCount
                ]);
            } else {
                $view->with([
                    'notificationsForLayout' => collect(),
                    'unreadNotificationsCountForLayout' => 0
                ]);
            }
        });
    }
}
