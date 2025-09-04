<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // Hapus kolom 'jabatan' yang lama jika ada dan Anda yakin datanya tidak lagi diperlukan.
            // Jika masih perlu, Anda harus melakukan migrasi data terlebih dahulu.
            // Untuk kesederhanaan, kita akan hapus kolom lama.
            if (Schema::hasColumn('pegawais', 'jabatan')) {
                $table->dropColumn('jabatan');
            }

            // Tambahkan kolom baru 'jabatan_id' sebagai foreign key
            $table->foreignId('jabatan_id')->nullable()->after('foto')->constrained('jabatans')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropForeign(['jabatan_id']);
            $table->dropColumn('jabatan_id');
            $table->string('jabatan')->nullable(); // Kembalikan kolom lama jika rollback
        });
    }
};
