<?php

namespace App\Notifications;

use App\Channels\FonnteChannel; // Import FonnteChannel
use App\Models\PengajuanTpp; // Import model
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TppDiajukanNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $pengajuanTpp; // Properti untuk menyimpan data pengajuan

    /**
     * Create a new notification instance.
     */
    public function __construct(PengajuanTpp $pengajuanTpp)
    {
        $this->pengajuanTpp = $pengajuanTpp;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail']; // Hapus FonnteChannel
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $namaBulan = date('F', mktime(0, 0, 0, $this->pengajuanTpp->periode_bulan, 10));

        return (new MailMessage)
                    ->greeting('Hello! ' . $notifiable->name)
                    ->subject('Pengajuan TPP Baru Memerlukan Verifikasi')
                    ->line('Ada pengajuan TPP baru yang memerlukan verifikasi Anda.')
                    ->line("Dari OPD: {$this->pengajuanTpp->opd?->nama_opd}")
                    ->line("Periode: Bulan {$namaBulan} Tahun {$this->pengajuanTpp->periode_tahun}")
                    ->line('Silakan periksa aplikasi untuk detail lebih lanjut.')
                    ->line('Terima kasih.')
                    ->salutation('Hormat kami, tim SiYanti BKPSDM');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'pengajuan_id' => $this->pengajuanTpp->id,
            'opd_nama' => $this->pengajuanTpp->opd?->nama_opd,
            'periode_bulan' => $this->pengajuanTpp->periode_bulan,
            'periode_tahun' => $this->pengajuanTpp->periode_tahun,
            'message' => 'Pengajuan TPP baru dari ' . ($this->pengajuanTpp->opd?->nama_opd ?? 'OPD tidak diketahui') . ' telah masuk.',
            'url' => route('pengajuan-tpp.show', ['pengajuanTpp' => $this->pengajuanTpp->id, 'hash' => $this->pengajuanTpp->getRouteHash()]),
        ];
    }

    /**
     * Get the Fonnte representation of the notification.
     */
    public function toFonnte(object $notifiable): string
    {
        $namaBulan = date('F', mktime(0, 0, 0, $this->pengajuanTpp->periode_bulan, 10));

        return "*Pemberitahuan Pengajuan TPP Baru*\n\n" .
               "Ada pengajuan TPP baru yang memerlukan verifikasi Anda.\n\n" .
               "*Dari OPD:*\n" .
               "{$this->pengajuanTpp->opd?->nama_opd}\n\n" .
               "*Periode:*\n" .
               "Bulan {$namaBulan} Tahun {$this->pengajuanTpp->periode_tahun}\n\n" .
               "Silakan periksa aplikasi untuk melakukan verifikasi.\n\n" .
               "Terima kasih.";
    }
}