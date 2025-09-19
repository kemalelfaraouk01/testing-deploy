<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class FonnteChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toFonnte($notifiable);

        // Get the phone number from the notifiable model
        $phoneNumber = $notifiable->nomor_hp;

        if (!$phoneNumber) {
            return;
        }

        $response = Http::withHeaders([
            'Authorization' => config('services.fonnte.token'),
        ])->post('https://api.fonnte.com/send', [
            'target' => $phoneNumber,
            'message' => $message,
        ]);

        // You can log the response for debugging purposes
        // Log::info('Fonnte API Response: ' . $response->body());
    }
}
