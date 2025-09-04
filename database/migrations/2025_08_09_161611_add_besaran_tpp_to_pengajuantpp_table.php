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
        Schema::table('pengajuantpp', function (Blueprint $table) {
            $table->decimal('besaran_tpp_diajukan', 15, 2)->nullable()->after('opd_id');
        });
    }

    public function down(): void
    {
        Schema::table('pengajuantpp', function (Blueprint $table) {
            $table->dropColumn('besaran_tpp_diajukan');
        });
    }
};
