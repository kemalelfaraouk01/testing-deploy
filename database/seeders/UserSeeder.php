<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Opd; // Import model Opd
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil OPD pertama sebagai default
        $opd = Opd::first();
        if (!$opd) {
            $this->command->error('Tidak ada data OPD. Jalankan OpdSeeder terlebih dahulu.');
            return;
        }


        // 2. Membuat User Admin
        $admin = User::updateOrCreate(
            ['nip' => '554433221111222233'],
            [
                'name' => 'Admin',
                'opd_id' => $opd->id,
                'password' => Hash::make('12345678'), // <-- KATA SANDI DIUBAH
            ]
        );
        $admin->assignRole('Admin');

        // 3. Membuat User Biasa
        $userBiasa = User::updateOrCreate(
            ['nip' => '112233445566778899'], // NIP unik untuk user biasa
            [
                'name' => 'User Biasa',
                'opd_id' => $opd->id,
                'password' => Hash::make('password'), // Ganti dengan password yang aman
            ]
        );
        $userBiasa->assignRole('User');
    }
}
