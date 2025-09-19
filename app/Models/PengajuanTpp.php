<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PengajuanTpp extends Model
{
    use HasFactory;

    protected $table = 'pengajuantpp'; // Menegaskan nama tabel
    // app/Models/PengajuanTpp.php
    protected $fillable = [
        'periode_bulan',
        'periode_tahun',
        'opd_id',
        'besaran_tpp_diajukan',
        'status',
        'keterangan',
        'berkas_tpp', // <-- Tambahkan
        'berkas_spj', // <-- Tambahkan
        'berkas_pernyataan', // <-- Tambahkan
        'berkas_pengantar', // <-- Tambahkan
    ];

    // Relasi ke OPD
    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class);
    }

    // Relasi ke User (pembuat pengajuan)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Pegawai (pembuat pengajuan)
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }

    // Relasi ke Pegawai (Many to Many)
    public function pegawais(): BelongsToMany
    {
        return $this->belongsToMany(Pegawai::class, 'pengajuan_tpp_pegawai')
            ->withPivot('jumlah_tpp_diterima', 'status_verifikasi', 'catatan_verifikator')
            ->withTimestamps();
    }

    public function getRouteHash(): string
    {
        // Membuat hash dari ID pengajuan dengan kunci rahasia aplikasi
        return hash_hmac('sha256', "pengajuan-tpp-id:{$this->id}", config('app.key'));
    }

    protected static function booted(): void
    {
        static::creating(function (PengajuanTpp $pengajuanTpp) {
            // 0. Set user_id dari pengguna yang login
            if (auth()->check()) {
                $pengajuanTpp->user_id = auth()->id();
            }

            // Generate a unique random 5-digit number.
            do {
                $randomNumber = random_int(10000, 99999);
            } while (self::where('nomor_pengajuan', $randomNumber)->exists());

            $pengajuanTpp->nomor_pengajuan = $randomNumber;
        });
    }
}
