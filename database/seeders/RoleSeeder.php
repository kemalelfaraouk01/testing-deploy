<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission; // <-- 1. Tambahkan import untuk Permission
use Spatie\Permission\PermissionRegistrar; // <-- Tambahkan ini untuk reset cache

class RoleSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk database.
     */
    public function run(): void
    {
        // 2. Reset cache roles dan permissions (praktik terbaik)
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 3. Buat permission baru
        Permission::firstOrCreate(['name' => 'kelola pengaturan']);
        Permission::firstOrCreate(['name' => 'usulkan satyalancana']);
        Permission::firstOrCreate(['name' => 'lengkapi berkas satyalancana']);

        // 4. Buat semua peran yang ada
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Kepala OPD']);
        Role::firstOrCreate(['name' => 'Kepala Bidang']);
        Role::firstOrCreate(['name' => 'Pengelola']);
        Role::firstOrCreate(['name' => 'Verifikasi TPP']);
        Role::firstOrCreate(['name' => 'Verif Cuti Kabid']);
        Role::firstOrCreate(['name' => 'Verif Cuti KaOPD']);
        $roleUser = Role::firstOrCreate(['name' => 'User']);
        $rolePengelolaSatyalancana = Role::firstOrCreate(['name' => 'Pengelola Satyalancana']);

        // 5. Berikan permission 'kelola pengaturan' ke peran 'Admin'
        $roleAdmin->givePermissionTo('kelola pengaturan');
        $roleUser->givePermissionTo('lengkapi berkas satyalancana');
        // Berikan permission 'usulkan satyalancana' ke peran baru
        $rolePengelolaSatyalancana->givePermissionTo('usulkan satyalancana');
    }
}
