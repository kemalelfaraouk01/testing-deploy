<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\LogsActivity;

class Cuti extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'pegawai_id',
        'jenis_cuti',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'status',
        'keterangan_penolakan',
        'id_kabid',
        'tgl_disetujui_kabid',
        'id_kaopd',
        'tgl_disetujui_kaopd'
    ];

    // Relasi: Satu Cuti dimiliki oleh satu Pegawai
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }

    // Relasi: Satu Cuti diverifikasi oleh satu User (atasan)
    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    public function kabidApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_kabid');
    }

    public function kaopdApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_kaopd');
    }
}
