<?php

namespace App\Notifications;

use App\Models\Satyalancana;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SatyalancanaPerluPerbaikanNotification extends Notification
{
    use Queueable;

    protected $satyalancana;

    public function __construct(Satyalancana $satyalancana)
    {
        $this->satyalancana = $satyalancana;
    }

    public function via($notifiable): array
    {
        return ['database']; // Kirim notifikasi ke database
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'Usulan Satyalancana Anda perlu perbaikan. Alasan: ' . $this->satyalancana->keterangan,
            'url' => route('berkas-satyalancana.create', $this->satyalancana->id), // Link ke halaman perbaikan
        ];
    }
}
