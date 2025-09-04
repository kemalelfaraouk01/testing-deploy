<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Opd;
use Illuminate\Support\Facades\Schema; // <-- TAMBAHKAN INI

class OpdSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk database.
     */
    public function run(): void
    {
        // 1. Nonaktifkan pengecekan foreign key
        Schema::disableForeignKeyConstraints();

        // 2. Kosongkan tabel opds dengan aman
        Opd::truncate();

        // 3. Aktifkan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();

        $opds = [
            [
                'kode_opd' => '1.01.01',
                'nama_opd' => 'Dinas Pendidikan dan Kebudayaan Kota Bengkulu',
                'alamat' => 'Jl. Cendana No. 20, Sawah Lebar, Kota Bengkulu'
            ],
            [
                'kode_opd' => '1.02.01',
                'nama_opd' => 'Dinas Kesehatan Kota Bengkulu',
                'alamat' => 'Jl. Basuki Rahmat, Padang Jati, Kota Bengkulu'
            ],
            [
                'kode_opd' => '1.03.01',
                'nama_opd' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kota Bengkulu',
                'alamat' => 'Jl. Cimanuk, Padang Harapan, Kota Bengkulu'
            ],
            [
                'kode_opd' => '2.07.01',
                'nama_opd' => 'Dinas Komunikasi dan Informatika Kota Bengkulu',
                'alamat' => 'Jl. WR Supratman, Bentiring, Kota Bengkulu'
            ],
            [
                'kode_opd' => '4.01.01',
                'nama_opd' => 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kota Bengkulu',
                'alamat' => 'Jl. WR Supratman No.12, Bentiring, Kota Bengkulu'
            ],
            [
                'kode_opd' => '4.02.01',
                'nama_opd' => 'Badan Perencanaan Pembangunan Daerah Kota Bengkulu',
                'alamat' => 'Jl. Basuki Rahmat No.1, Padang Jati, Kota Bengkulu'
            ]
        ];

        // Masukkan data ke dalam tabel opds
        foreach ($opds as $opd) {
            Opd::create($opd);
        }
    }
}
