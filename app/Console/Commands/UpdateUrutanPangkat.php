<?php

namespace App\Console\Commands;

use App\Models\Pegawai;
use Illuminate\Console\Command;

class UpdateUrutanPangkat extends Command
{
    protected $signature = 'pegawai:update-pangkat-order';
    protected $description = 'Update urutan pangkat untuk semua pegawai';

    public function handle()
    {
        $pangkatOrder = [
            'IV/e' => 1,
            'IV/d' => 2,
            'IV/c' => 3,
            'IV/b' => 4,
            'IV/a' => 5,
            'III/d' => 6,
            'III/c' => 7,
            'III/b' => 8,
            'III/a' => 9,
            'II/d' => 10,
            'II/c' => 11,
            'II/b' => 12,
            'II/a' => 13,
            'I/d' => 14,
            'I/c' => 15,
            'I/b' => 16,
            'I/a' => 17,
        ];

        Pegawai::all()->each(function ($pegawai) use ($pangkatOrder) {
            $pegawai->urutan_pangkat = $pangkatOrder[$pegawai->golongan] ?? 999;
            $pegawai->save();
        });

        $this->info('Urutan pangkat semua pegawai berhasil diperbarui.');
    }
}
