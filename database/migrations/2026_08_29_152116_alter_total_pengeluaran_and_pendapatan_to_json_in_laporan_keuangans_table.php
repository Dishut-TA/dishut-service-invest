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
        Schema::table('laporan_keuangans', function (Blueprint $table) {
            $table->dropColumn(['total_pendapatan', 'total_pengeluaran']);
        });

        Schema::table('laporan_keuangans', function (Blueprint $table) {
            $table->json('total_pendapatan')->nullable();
            $table->json('total_pengeluaran')->nullable();
            $table->enum('status', ['DRAFT', 'SUBMITTED', 'REVISED', 'APPROVED'])->default('DRAFT')->after('catatan_verifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_keuangans', function (Blueprint $table) {
            $table->dropColumn(['total_pendapatan', 'total_pengeluaran', 'status']);
        });
        
        Schema::table('laporan_keuangans', function (Blueprint $table) {
            $table->decimal('total_pendapatan', 15, 2)->default(0);
            $table->decimal('total_pengeluaran', 15, 2)->default(0);
        });
    }
};
