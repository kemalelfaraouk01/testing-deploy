<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuantpp', function (Blueprint $table) {
            // Mengubah enum untuk menambahkan status baru 'perlu_perbaikan'
            $table->enum('status', ['draft', 'diajukan', 'disetujui', 'ditolak', 'perlu_perbaikan'])
                ->default('draft')->change();
        });
    }

    public function down(): void
    {
        Schema::table('pengajuantpp', function (Blueprint $table) {
            // Mengembalikan ke state semula jika di-rollback
            $table->enum('status', ['draft', 'diajukan', 'disetujui', 'ditolak'])
                ->default('draft')->change();
        });
    }
};
