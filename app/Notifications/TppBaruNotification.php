<?php

namespace App\Notifications;

use App\Channels\FonnteChannel;
use App\Models\PengajuanTpp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TppBaruNotification extends Notification
{
    use Queueable;

    protected $pengajuanTpp;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PengajuanTpp $pengajuanTpp)
    {
        $this->pengajuanTpp = $pengajuanTpp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $opd = $this->pengajuanTpp->opd->nama_opd;
        $periode = $this->pengajuanTpp->created_at->format('F Y');

        return (new MailMessage)
                    ->subject('Pemberitahuan Pengajuan TPP Baru')
                    ->line("Ada pengajuan TPP baru dari OPD: {$opd} untuk periode {$periode}.")
                    ->line('Mohon untuk segera melakukan verifikasi.')
                    ->line('Terima kasih telah menggunakan aplikasi kami!')
                    ->salutation('Hormat kami, tim SiYanti BKPSDM');
    }

    /**
     * Get the Fonnte representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function toFonnte($notifiable)
    {
        // Gunakan relasi ->opd yang merupakan belongsTo dan sudah pasti ada
        $opd = $this->pengajuanTpp->opd->nama_opd; // Menggunakan nama_opd sesuai file model
        $periode = $this->pengajuanTpp->created_at->format('F Y');

        return "Pemberitahuan Pengajuan TPP Baru

Ada pengajuan TPP baru dari:
*OPD:* {$opd}
*Periode:* {$periode}

Mohon untuk segera melakukan verifikasi.

Terima kasih.";
    }
}