<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuantpp', function (Blueprint $table) {
            $table->string('berkas_tpp')->nullable()->after('keterangan');
            $table->string('berkas_spj')->nullable()->after('berkas_tpp');
            $table->string('berkas_pernyataan')->nullable()->after('berkas_spj');
            $table->string('berkas_pengantar')->nullable()->after('berkas_pernyataan');
        });
    }

    public function down(): void
    {
        Schema::table('pengajuantpp', function (Blueprint $table) {
            $table->dropColumn(['berkas_tpp', 'berkas_spj', 'berkas_pernyataan', 'berkas_pengantar']);
        });
    }
};
