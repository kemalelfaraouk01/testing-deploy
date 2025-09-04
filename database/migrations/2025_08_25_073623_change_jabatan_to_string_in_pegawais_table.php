<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // 1. Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['jabatan_id']);
            // 2. Hapus kolom jabatan_id
            $table->dropColumn('jabatan_id');
            // 3. Tambahkan kolom jabatan baru sebagai string
            $table->string('jabatan')->nullable()->after('foto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // 1. Hapus kolom jabatan string
            $table->dropColumn('jabatan');
            // 2. Tambahkan kembali kolom jabatan_id
            $table->foreignId('jabatan_id')->nullable()->constrained('jabatans')->onDelete('set null');
        });
    }
};
