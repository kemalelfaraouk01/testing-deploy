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
        Schema::table('pensiuns', function (Blueprint $table) {
            $table->text('catatan_perbaikan')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pensiuns', function (Blueprint $table) {
            $table->dropColumn('catatan_perbaikan');
        });
    }
};