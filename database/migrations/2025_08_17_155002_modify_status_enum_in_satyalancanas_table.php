<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Menambahkan 'perlu_perbaikan' ke daftar ENUM yang ada
        DB::statement("ALTER TABLE satyalancanas MODIFY COLUMN status ENUM('diusulkan', 'menunggu_kelengkapan_berkas', 'berkas_lengkap', 'diverifikasi', 'disetujui', 'ditolak', 'perlu_perbaikan') NOT NULL DEFAULT 'diusulkan'");
    }

    public function down(): void
    {
        // Mengembalikan ke kondisi semula jika migrasi di-rollback
        DB::statement("ALTER TABLE satyalancanas MODIFY COLUMN status ENUM('diusulkan', 'menunggu_kelengkapan_berkas', 'berkas_lengkap', 'diverifikasi', 'disetujui', 'ditolak') NOT NULL DEFAULT 'diusulkan'");
    }
};
