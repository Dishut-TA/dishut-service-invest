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
        Schema::create('kth_wallet_mutasis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('kth_wallet_id')->constrained('kth_wallets')->cascadeOnDelete();
            $table->uuid('referensi_id')->nullable()->comment('ID transaksi pendanaan / ID penarikan');
            $table->enum('tipe_mutasi', ['KREDIT', 'DEBIT']);
            $table->decimal('nominal', 15, 2);
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kth_wallet_mutasis');
    }
};
