<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPangkat extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'pangkat',
        'golongan',
        'jabatan',
        'unit_kerja',
        'tmt_pangkat',
        'nomor_sk',
        'tanggal_sk'
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
