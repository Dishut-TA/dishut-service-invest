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
        Schema::table('transaksi_pendanaans', function (Blueprint $table) {
            $table->string('nama', 255)->nullable()->after('investor_id');
            $table->string('email', 255)->nullable()->after('nama');
            $table->string('no_telp', 50)->nullable()->after('email');
            $table->string('dokumen_url', 255)->nullable()->after('bukti_transfer_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_pendanaans', function (Blueprint $table) {
            $table->dropColumn(['nama', 'email', 'no_telp', 'dokumen_url']);
        });
    }
};
