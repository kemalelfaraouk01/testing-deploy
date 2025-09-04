<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Opd extends Model
{
    use HasFactory;

    // ▼▼▼ TAMBAHKAN PROPERTI INI ▼▼▼
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_opd',
        'nama_opd',
        'alamat',
    ];
    // ▲▲▲ BATAS AKHIR PENAMBAHAN KODE ▲▲▲


    public function pegawais(): HasMany
    {
        return $this->hasMany(Pegawai::class);
    }
}
