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
        Schema::create('riwayat_jabatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('jabatan');
            $table->string('unit_kerja');
            $table->enum('jenis_jabatan', ['Struktural', 'Fungsional', 'Pelaksana']);
            $table->date('tmt_jabatan'); // Terhitung Mulai Tanggal Jabatan
            $table->string('nomor_sk');
            $table->date('tanggal_sk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_jabatans');
    }
};
