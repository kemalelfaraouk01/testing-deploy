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
        'catatan_perbaikan',
        'berkas_dpcp',
        'berkas_sk_cpns_pns',
        'berkas_sk_pangkat_terakhir',
        'berkas_kk',
        'berkas_pas_foto',
        'berkas_lainnya',
    ];

    public static $berkasFields = [
        'berkas_dpcp' => 'Data Perorangan Calon Penerima Pensiun (DCPC)',
        'berkas_sk_cpns_pns' => 'SK CPNS dan PNS',
        'berkas_sk_pangkat_terakhir' => 'SK Pangkat Terakhir',
        'berkas_kk' => 'Kartu Keluarga (KK)',
        'berkas_pas_foto' => 'Pas Foto Terbaru',
        'berkas_lainnya' => 'Berkas Pendukung Lainnya',
    ];

    /**
     * Mendapatkan data pegawai yang berelasi dengan pensiun ini.
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    /**
     * Membuat hash unik untuk URL.
     */
    public function getRouteHash(): string
    {
        return hash_hmac('sha256', "pensiun-id:{$this->id}", config('app.key'));
    }
}
