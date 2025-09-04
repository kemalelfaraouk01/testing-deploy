<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('satyalancanas', function (Blueprint $table) {
            // Kolom untuk menyimpan periode, contoh: 'Agustus 2025' atau 'November 2025'
            $table->string('periode')->nullable()->after('tahun_pengusulan');
        });
    }

    public function down(): void
    {
        Schema::table('satyalancanas', function (Blueprint $table) {
            $table->dropColumn('periode');
        });
    }
};
