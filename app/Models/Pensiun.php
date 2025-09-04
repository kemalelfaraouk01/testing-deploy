<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pensiun extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'tanggal_pensiun',
        'jenis_pensiun',
        'no_sk',
        'tanggal_sk',
        'status',
        'keterangan',
    ];

    /**
     * Mendapatkan data pegawai yang berelasi dengan pensiun ini.
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
