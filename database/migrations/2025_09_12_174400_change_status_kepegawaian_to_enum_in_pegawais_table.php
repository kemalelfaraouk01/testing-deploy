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
            // Mengubah kolom menjadi ENUM dengan nilai yang ditentukan
            $table->enum('status_kepegawaian', ['PNS', 'CPNS', 'PPPK', 'Honorer'])->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // Mengembalikan kolom ke tipe string jika migrasi di-rollback
            $table->string('status_kepegawaian')->nullable()->change();
        });
    }
};