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
            // Tambahkan kolom opd_id setelah kolom user_id
            $table->foreignId('opd_id')
                ->nullable() // Pegawai boleh tidak punya OPD (fleksibel)
                ->after('user_id')
                ->constrained('opds') // Terhubung ke tabel 'opds'
                ->onDelete('set null'); // Jika OPD dihapus, opd_id pegawai jadi NULL
        });
    }

    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // Perintah untuk membatalkan migrasi (rollback)
            $table->dropForeign(['opd_id']);
            $table->dropColumn('opd_id');
        });
    }
};
