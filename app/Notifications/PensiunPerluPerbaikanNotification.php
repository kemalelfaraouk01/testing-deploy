<?php

namespace App\Notifications;

use App\Models\Pensiun;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PensiunPerluPerbaikanNotification extends Notification
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
        return ['database'];
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
            'message' => 'Usulan pensiun Anda perlu perbaikan. Mohon periksa catatan dan perbarui berkas Anda.',
            'url' => route('berkas-pensiun.create', ['pensiun' => $this->pensiun->id, 'hash' => $this->pensiun->getRouteHash()]), // Arahkan kembali ke halaman upload
            'catatan' => $this->pensiun->catatan_perbaikan, // Sertakan catatan dari operator
        ];
    }
}