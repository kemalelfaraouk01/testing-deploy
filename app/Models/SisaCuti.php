<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SisaCuti extends Model
{
    protected $fillable = ['pegawai_id', 'tahun', 'jatah_cuti_diambil', 'sisa_cuti_tahun_lalu', 'sisa_cuti_2_tahun_lalu'];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
