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
            $table->index('status'); // Menambahkan index pada kolom status
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('satyalancanas', function (Blueprint $table) {
            $table->dropIndex(['status']); // Menghapus index jika migration di-rollback
        });
    }
};