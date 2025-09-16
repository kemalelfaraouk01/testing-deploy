<?php

namespace App\Notifications;

use App\Models\PengajuanTpp; // Import model
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TppDiajukanNotification extends Notification
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
        return ['database']; // Kita akan simpan notifikasi ini ke database
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $url = route('pengajuan-tpp.show', [
            'pengajuanTpp' => $this->pengajuanTpp->id,
            'hash' => $this->pengajuanTpp->getRouteHash()
        ]);

        return [
            'pengajuan_id' => $this->pengajuanTpp->id,
            'opd_nama' => $this->pengajuanTpp->opd->nama_opd,
            'periode_bulan' => $this->pengajuanTpp->periode_bulan,
            'periode_tahun' => $this->pengajuanTpp->periode_tahun,
            'message' => 'Pengajuan TPP baru dari ' . $this->pengajuanTpp->opd->nama_opd . ' telah masuk.',
            'url' => $url // Menambahkan URL lengkap
        ];
    }
}