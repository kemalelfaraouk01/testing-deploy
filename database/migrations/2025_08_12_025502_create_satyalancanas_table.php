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
        Schema::create('satyalancanas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('jenis_penghargaan')->default('Satyalancana Karya Satya');
            $table->integer('masa_kerja'); // 10, 20, atau 30
            $table->year('tahun_pengusulan');
            $table->enum('status', ['diajukan', 'diverifikasi', 'disetujui', 'ditolak'])->default('diajukan');
            $table->text('keterangan')->nullable();
            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satyalancanas');
    }
};
