<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Pegawai extends Model
{
    use HasFactory;

    public static $all_statuses = ['PNS', 'CPNS', 'PPPK', 'Honorer', 'Pensiun'];
    public static $selectable_statuses = ['PNS', 'CPNS', 'PPPK', 'Honorer'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'opd_id',
        'nama_lengkap',
        'jenis_kelamin',
        'agama',
        'status_perkawinan',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'email',
        'foto',
        'jabatan',
        'jenis_jabatan',
        'pangkat',
        'golongan',
        'unit_kerja',
        'status_kepegawaian',
        'jenis_kepegawaian',
        'tmt_cpns',
        'tmt_pns',
        'tmt_jabatan',
        'nomor_sk_cpns',
        'nomor_sk_pns',
        'dokumen_sk_cpns',
        'dokumen_sk_pns',
        'pendidikan_terakhir',
        'jurusan',
        'asal_sekolah',
        'tahun_lulus',
        'npwp',
        'bpjs_kesehatan',
        'bpjs_ketenagakerjaan',
        'rekening_bank',
        'nama_bank',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu Pegawai dimiliki oleh satu OPD
    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class);
    }

    public function pengajuanTpps(): BelongsToMany
    {
        return $this->belongsToMany(PengajuanTpp::class, 'pengajuan_tpp_pegawai');
    }

    public function cutis(): HasMany
    {
        return $this->hasMany(Cuti::class);
    }

    public function sisaCutis(): HasMany
    {
        return $this->hasMany(SisaCuti::class);
    }

    // app/Models/Pegawai.php
    public function riwayatPangkats(): HasMany
    {
        // Urutkan dari yang paling baru
        return $this->hasMany(RiwayatPangkat::class)->orderBy('tmt_pangkat', 'desc');
    }

    public function satyalancanas(): HasMany
    {
        return $this->hasMany(Satyalancana::class);
    }

    public function riwayatJabatans(): HasMany
    {
        return $this->hasMany(RiwayatJabatan::class)->orderBy('tmt_jabatan', 'desc');
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }
}
