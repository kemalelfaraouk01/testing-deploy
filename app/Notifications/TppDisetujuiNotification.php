<?php

namespace App\Notifications;

use App\Models\PengajuanTpp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TppDisetujuiNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $pengajuanTpp;

    /**
     * Create a new notification instance.
     */
    public function __construct(PengajuanTpp $pengajuanTpp)
    {
        $this->pengajuanTpp = $pengajuanTpp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('pengajuan-tpp.show', $this->pengajuanTpp->id);
        $namaBulan = date('F', mktime(0, 0, 0, $this->pengajuanTpp->periode_bulan, 10));

        return (new MailMessage)
                    ->subject('Pengajuan TPP Anda Telah Disetujui')
                    ->line("Selamat! Pengajuan TPP Anda untuk periode {$namaBulan} {$this->pengajuanTpp->periode_tahun} telah disetujui.")
                    ->action('Lihat Detail', $url)
                    ->line('Terima kasih telah menggunakan aplikasi kami.')
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
            'pengajuan_id' => $this->pengajuanTpp->id,
            'message' => 'Selamat! Pengajuan TPP Anda untuk periode ' . date('F', mktime(0, 0, 0, $this->pengajuanTpp->periode_bulan, 10)) . ' ' . $this->pengajuanTpp->periode_tahun . ' telah disetujui.',
            'url' => route('pengajuan-tpp.show', $this->pengajuanTpp->id),
        ];
    }
}
