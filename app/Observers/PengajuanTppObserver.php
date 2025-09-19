<?php

namespace App\Observers;

use App\Models\PengajuanTpp;
use App\Models\User;
use App\Notifications\TppBaruNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log; // Tambahkan ini

class PengajuanTppObserver
{
    /**
     * Handle the PengajuanTpp "created" event.
     *
     * @param  \App\Models\PengajuanTpp  $pengajuanTpp
     * @return void
     */
    public function created(PengajuanTpp $pengajuanTpp)
    {
        // Ambil semua user dengan role 'verifikasi tpp'
        $verifikator = User::role('verifikasi tpp')->get();

        Log::info('Mencari verifikator TPP. Ditemukan: ' . $verifikator->count() . ' user.');

        // Kirim notifikasi ke setiap verifikator
        if ($verifikator->isNotEmpty()) {
            $pengajuanTpp->load('opd'); // Cukup load relasi opd
            Notification::send($verifikator, new TppBaruNotification($pengajuanTpp));
            Log::info('Notifikasi TPP Baru telah dikirim ke antrian untuk ' . $verifikator->count() . ' user.');
        } else {
            Log::warning('Tidak ada user dengan role "verifikasi tpp" yang ditemukan. Notifikasi tidak dikirim.');
        }
    }
}