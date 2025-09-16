<?php

namespace App\Notifications;

use App\Models\Pensiun;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PensiunDiajukanNotification extends Notification
{
    use Queueable;

    protected $pensiun;

    /**
     * Create a new notification instance.
     */
    public function __construct(Pensiun $pensiun)
    {
        $this->pensiun = $pensiun;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Kirim notifikasi ke database
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'pensiun_id' => $this->pensiun->id,
            'pegawai_nama' => $this->pensiun->pegawai->nama_lengkap,
            'message' => 'Anda telah diusulkan untuk pensiun. Mohon segera lengkapi berkas persyaratan Anda.',
            'url' => route('berkas-pensiun.create', ['pensiun' => $this->pensiun->id, 'hash' => $this->pensiun->getRouteHash()]), // Rute untuk melengkapi berkas
        ];
    }
}