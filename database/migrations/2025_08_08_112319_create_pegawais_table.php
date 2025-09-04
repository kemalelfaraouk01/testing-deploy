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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('agama')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('foto')->nullable();

            // Data Kepegawaian
            $table->string('jabatan')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('golongan')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->string('status_kepegawaian')->nullable(); // PNS, PPPK, Honorer
            $table->string('jenis_kepegawaian')->nullable();  // Struktural, Fungsional
            $table->date('tmt_cpns')->nullable();
            $table->date('tmt_pns')->nullable();
            $table->date('tmt_jabatan')->nullable();
            $table->string('nomor_sk_cpns')->nullable();
            $table->string('nomor_sk_pns')->nullable();
            $table->string('dokumen_sk_cpns')->nullable();
            $table->string('dokumen_sk_pns')->nullable();

            // Data Pendidikan
            $table->string('pendidikan_terakhir')->nullable(); // S1, S2, D3, SMA
            $table->string('jurusan')->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->year('tahun_lulus')->nullable();

            // Data Tambahan
            $table->string('npwp')->nullable();
            $table->string('bpjs_kesehatan')->nullable();
            $table->string('bpjs_ketenagakerjaan')->nullable();
            $table->string('rekening_bank')->nullable();
            $table->string('nama_bank')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
