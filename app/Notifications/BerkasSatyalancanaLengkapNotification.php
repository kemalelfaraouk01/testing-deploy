<?php

namespace App\Notifications;

use App\Models\Satyalancana;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BerkasSatyalancanaLengkapNotification extends Notification
{
    use Queueable;
    public $satyalancana;

    public function __construct(Satyalancana $satyalancana)
    {
        $this->satyalancana = $satyalancana;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'satyalancana_id' => $this->satyalancana->id,
            'pegawai_nama' => $this->satyalancana->pegawai->nama_lengkap,
            'message' => 'Berkas Satyalancana dari ' . $this->satyalancana->pegawai->nama_lengkap . ' telah lengkap dan siap diverifikasi.',
        ];
    }
}
