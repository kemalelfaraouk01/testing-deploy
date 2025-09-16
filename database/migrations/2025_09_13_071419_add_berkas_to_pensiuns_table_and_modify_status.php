<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pensiuns', function (Blueprint $table) {
            // 1. Tambah kolom untuk berkas-berkas
            $table->string('berkas_dpcp')->nullable()->after('keterangan');
            $table->string('berkas_sk_cpns_pns')->nullable()->after('berkas_dpcp');
            $table->string('berkas_sk_pangkat_terakhir')->nullable()->after('berkas_sk_cpns_pns');
            $table->string('berkas_kk')->nullable()->after('berkas_sk_pangkat_terakhir');
            $table->string('berkas_pas_foto')->nullable()->after('berkas_kk');
            $table->string('berkas_lainnya')->nullable()->after('berkas_pas_foto');
        });

        // 2. Ubah tipe data kolom status ENUM
        DB::statement("ALTER TABLE pensiuns MODIFY COLUMN status ENUM('Menunggu Berkas', 'Berkas Lengkap', 'Perlu Perbaikan', 'Diproses', 'Selesai') NOT NULL DEFAULT 'Menunggu Berkas'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pensiuns', function (Blueprint $table) {
            $table->dropColumn([
                'berkas_dpcp',
                'berkas_sk_cpns_pns',
                'berkas_sk_pangkat_terakhir',
                'berkas_kk',
                'berkas_pas_foto',
                'berkas_lainnya',
            ]);
        });

        // Kembalikan tipe data kolom status ENUM ke definisi awal
        DB::statement("ALTER TABLE pensiuns MODIFY COLUMN status ENUM('Diusulkan', 'Diproses', 'Selesai') NOT NULL DEFAULT 'Diusulkan'");
    }
};