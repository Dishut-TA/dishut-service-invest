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
        Schema::table('laporan_proyeks', function (Blueprint $table) {
            $table->decimal('dana_terpakai', 15, 2)->default(0)->after('deskripsi_kemajuan');
            $table->decimal('sisa_dana', 15, 2)->default(0)->after('dana_terpakai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_proyeks', function (Blueprint $table) {
            $table->dropColumn(['dana_terpakai', 'sisa_dana']);
        });
    }
};
