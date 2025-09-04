<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatJabatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'pegawai_id',
        'jabatan',
        'unit_kerja',
        'jenis_jabatan',
        'tmt_jabatan',
        'nomor_sk',
        'tanggal_sk'
    ];
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
