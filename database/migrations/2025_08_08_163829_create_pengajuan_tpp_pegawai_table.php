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
        Schema::create('pengajuan_tpp_pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_tpp_id')->constrained('pengajuantpp')->onDelete('cascade');
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');

            // Kolom tambahan untuk data spesifik per pegawai
            $table->decimal('jumlah_tpp_diterima', 15, 2)->nullable();
            $table->string('status_verifikasi')->default('menunggu'); // menunggu, valid, tidak valid
            $table->text('catatan_verifikator')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_tpp_pegawai');
    }
};
