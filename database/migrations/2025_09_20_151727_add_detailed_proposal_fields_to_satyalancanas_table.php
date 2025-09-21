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
        Schema::table('satyalancanas', function (Blueprint $table) {
            $table->string('no_sk_hukdis')->nullable()->after('status');
            $table->string('no_sk_cltn')->nullable()->after('no_sk_hukdis');
            $table->string('slks_lama')->nullable()->after('no_sk_cltn');
            $table->string('no_keppres')->nullable()->after('slks_lama');
            $table->date('tanggal_keppres')->nullable()->after('no_keppres');
            $table->string('ms_tms')->nullable()->after('tanggal_keppres');
            $table->text('keterangan_operator')->nullable()->after('ms_tms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('satyalancanas', function (Blueprint $table) {
            $table->dropColumn([
                'no_sk_hukdis',
                'no_sk_cltn',
                'slks_lama',
                'no_keppres',
                'tanggal_keppres',
                'ms_tms',
                'keterangan_operator',
            ]);
        });
    }
};