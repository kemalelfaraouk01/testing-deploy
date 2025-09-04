<?php

namespace App\Notifications;

use App\Models\Satyalancana; // Import model
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SatyalancanaDiajukanNotification extends Notification
{
    use Queueable;

    public $satyalancana;

    public function __construct(Satyalancana $satyalancana)
    {
        $this->satyalancana = $satyalancana;
    }

    public function via(object $notifiable): array
    {
        return ['database']; // Simpan ke database
    }

    public function toArray(object $notifiable): array
    {
        return [
            'satyalancana_id' => $this->satyalancana->id,
            'masa_kerja' => $this->satyalancana->masa_kerja,
            'message' => 'Anda diusulkan untuk penghargaan Satyalancana ' . $this->satyalancana->masa_kerja . ' tahun. Harap lengkapi berkas Anda.',
        ];
    }
}
