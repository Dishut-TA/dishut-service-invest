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
        Schema::create('investor_wallet_mutasis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('investor_wallet_id')->constrained('investor_dividen_wallets')->cascadeOnDelete();
            $table->uuid('referensi_id')->nullable();
            $table->enum('tipe_mutasi', ['KREDIT', 'DEBIT']);
            $table->decimal('nominal', 15, 2);
            $table->string('metode_pembayaran', 100)->nullable();
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_wallet_mutasis');
    }
};
