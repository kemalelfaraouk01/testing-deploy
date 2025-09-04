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
        Schema::create('pengajuantpp', function (Blueprint $table) {
            $table->id();
            $table->integer('periode_bulan'); // 1 = Januari, 2 = Februari, dst.
            $table->year('periode_tahun');
            $table->foreignId('opd_id')->constrained('opds')->onDelete('cascade');
            $table->enum('status', ['draft', 'diajukan', 'disetujui', 'ditolak'])->default('draft');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_tpps');
    }
};
