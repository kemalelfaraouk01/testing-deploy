<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cutis', function (Blueprint $table) {
            // Hapus kolom lama
            $table->dropColumn('status');
            $table->dropForeign(['disetujui_oleh']);
            $table->dropColumn('disetujui_oleh');

            // Tambah kolom baru untuk alur berjenjang
            $table->enum('status', [
                'diajukan',
                'disetujui_kabid', // Disetujui Kepala Bidang
                'disetujui_kaopd', // Disetujui Kepala OPD
                'ditolak'
            ])->default('diajukan')->after('keterangan');

            $table->foreignId('id_kabid')->nullable()->after('status')->constrained('users')->onDelete('set null');
            $table->timestamp('tgl_disetujui_kabid')->nullable()->after('id_kabid');

            $table->foreignId('id_kaopd')->nullable()->after('tgl_disetujui_kabid')->constrained('users')->onDelete('set null');
            $table->timestamp('tgl_disetujui_kaopd')->nullable()->after('id_kaopd');
        });
    }

    public function down(): void // Untuk rollback
    {
        Schema::table('cutis', function (Blueprint $table) {
            // Kembalikan kolom lama
            $table->enum('status', ['diajukan', 'disetujui', 'ditolak'])->default('diajukan');
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users')->onDelete('set null');

            // Hapus kolom baru
            $table->dropForeign(['id_kabid']);
            $table->dropColumn('id_kabid');
            $table->dropColumn('tgl_disetujui_kabid');

            $table->dropForeign(['id_kaopd']);
            $table->dropColumn('id_kaopd');
            $table->dropColumn('tgl_disetujui_kaopd');
        });
    }
};
