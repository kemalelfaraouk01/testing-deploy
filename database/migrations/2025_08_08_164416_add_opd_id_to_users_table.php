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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom opd_id setelah kolom 'nip'
            $table->foreignId('opd_id')
                ->nullable() // Boleh kosong, misal untuk Admin utama
                ->after('nip')
                ->constrained('opds')
                ->onDelete('set null'); // Jika OPD dihapus, opd_id user jadi NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['opd_id']);
            $table->dropColumn('opd_id');
        });
    }
};
