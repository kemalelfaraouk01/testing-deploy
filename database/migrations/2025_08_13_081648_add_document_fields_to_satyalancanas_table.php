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
        Schema::table('satyalancanas', function (Blueprint $table) {
            // 1. Ubah kolom status untuk alur baru
            $table->enum('status', [
                'diusulkan',                // Awal saat Pengelola mengusulkan
                'menunggu_kelengkapan_berkas', // Menunggu kandidat upload
                'berkas_lengkap',           // Kandidat sudah submit, menunggu verifikasi
                'disetujui',                // Final
                'ditolak'
            ])->default('diusulkan')->change();

            // 2. Tambahkan kolom untuk setiap file dokumen
            $table->string('file_drh')->nullable();
            $table->string('file_sk_cpns')->nullable();
            $table->string('file_sk_pangkat_terakhir')->nullable();
            $table->string('file_sk_jabatan_terakhir')->nullable();
            $table->string('file_surat_pernyataan_disiplin')->nullable();
            $table->string('file_skp')->nullable();
            $table->string('file_sptjm')->nullable();
            $table->string('file_piagam_sebelumnya')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('satyalancanas', function (Blueprint $table) {
            //
        });
    }
};
