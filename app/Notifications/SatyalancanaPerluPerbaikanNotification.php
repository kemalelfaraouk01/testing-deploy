<?php

namespace App\Notifications;

use App\Models\Satyalancana;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
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
        return ['database', 'mail']; // Kirim notifikasi ke database dan email
    }

    public function toMail($notifiable): MailMessage
    {
        $url = route('berkas-satyalancana.create', $this->satyalancana->id);

        return (new MailMessage)
                    ->subject('Perbaikan Berkas Usulan Satyalancana')
                    ->line('Terdapat perbaikan yang diperlukan untuk berkas usulan Satyalancana Anda.')
                    ->line('Catatan dari verifikator: ' . $this->satyalancana->keterangan)
                    ->action('Perbaiki Berkas Sekarang', $url)
                    ->line('Mohon perbarui berkas Anda sesuai catatan di atas. Terima kasih.')
                    ->salutation('Hormat kami, tim SiYanti BKPSDM');
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'Usulan Satyalancana Anda perlu perbaikan. Alasan: ' . $this->satyalancana->keterangan,
            'url' => route('berkas-satyalancana.create', $this->satyalancana->id), // Link ke halaman perbaikan
        ];
    }
}