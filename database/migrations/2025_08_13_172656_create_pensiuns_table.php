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
        Schema::create('pensiuns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->date('tanggal_pensiun');
            $table->enum('jenis_pensiun', ['BUP', 'Janda/Duda', 'Atas Permintaan Sendiri', 'Lainnya']);
            $table->string('no_sk')->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->enum('status', ['Diusulkan', 'Diproses', 'Selesai'])->default('Diusulkan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pensiuns');
    }
};
