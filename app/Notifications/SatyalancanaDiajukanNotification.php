<?php

namespace App\Notifications;

use App\Models\Satyalancana; // Import model
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
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
        return ['database', 'mail']; // Simpan ke database dan kirim email
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = route('berkas-satyalancana.create', $this->satyalancana->id);
        $masaKerja = $this->satyalancana->masa_kerja;

        return (new MailMessage)
                    ->subject("Usulan Satyalancana {$masaKerja} Tahun")
                    ->line("Anda telah diusulkan untuk menerima penghargaan Satyalancana {$masaKerja} tahun.")
                    ->line('Untuk melanjutkan proses, mohon lengkapi berkas persyaratan Anda dengan menekan tombol di bawah ini.')
                    ->action('Lengkapi Berkas Satyalancana', $url)
                    ->line('Terima kasih.')
                    ->salutation('Hormat kami, tim SiYanti BKPSDM');
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
