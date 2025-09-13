<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menambahkan 'Pensiun' ke dalam daftar ENUM yang ada
        DB::statement("ALTER TABLE pegawais CHANGE COLUMN status_kepegawaian status_kepegawaian ENUM('PNS', 'CPNS', 'PPPK', 'Honorer', 'Pensiun') NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus 'Pensiun' dari daftar ENUM jika di-rollback
        DB::statement("ALTER TABLE pegawais CHANGE COLUMN status_kepegawaian status_kepegawaian ENUM('PNS', 'CPNS', 'PPPK', 'Honorer') NULL DEFAULT NULL");
    }
};