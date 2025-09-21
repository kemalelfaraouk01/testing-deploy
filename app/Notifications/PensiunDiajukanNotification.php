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
        return ['database', 'mail']; // Kirim notifikasi ke database dan email
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Usulan Pensiun dan Permintaan Kelengkapan Berkas')
                    ->line('Anda telah diusulkan untuk pensiun oleh OPD Anda.')
                    ->line('Mohon untuk segera melengkapi berkas persyaratan Anda melalui aplikasi.')
                    ->line('Terima kasih.')
                    ->salutation('Hormat kami, tim SiYanti BKPSDM');
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
            'url' => '#', // Rute untuk melengkapi berkas
        ];
    }
}