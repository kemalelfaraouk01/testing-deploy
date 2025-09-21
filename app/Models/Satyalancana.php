<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Satyalancana extends Model
{
    use HasFactory;
    protected $fillable = [
        'pegawai_id',
        'jenis_penghargaan',
        'masa_kerja',
        'tahun_pengusulan',
        'periode',
        'status',
        'keterangan',
        'diverifikasi_oleh',
        'file_drh',
        'file_sk_cpns',
        'file_sk_pangkat_terakhir',
        'file_sk_jabatan_terakhir',
        'file_surat_pernyataan_disiplin',
        'file_skp',
        'file_sptjm',
        'file_piagam_sebelumnya',
        'no_sk_hukdis',
        'no_sk_cltn',
        'slks_lama',
        'no_keppres',
        'tanggal_keppres',
        'ms_tms',
        'keterangan_operator',
    ];
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
    public function diverifikasiOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    /**
     * Membuat hash unik untuk URL.
     */
    public function getRouteHash(): string
    {
        return hash_hmac('sha256', "satyalancana-id:{$this->id}", config('app.key'));
    }
}