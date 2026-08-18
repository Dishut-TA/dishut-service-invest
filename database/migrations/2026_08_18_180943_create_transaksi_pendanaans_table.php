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
        Schema::create('transaksi_pendanaans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('investor_id')->comment('Ref -> service-user');
            $table->foreignUuid('program_id')->constrained('program_investasis')->cascadeOnDelete();
            $table->decimal('nominal_pendanaan', 15, 2);
            $table->decimal('persentase_kepemilikan', 5, 2)->comment('(nominal/target) * 100%');
            $table->enum('status_pembayaran', ['PENDING', 'SUCCESS', 'FAILED', 'REFUNDED'])->default('PENDING');
            $table->string('metode_pembayaran', 100)->nullable();
            $table->string('bukti_transfer_url', 255)->nullable();
            $table->timestamp('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_pendanaans');
    }
};
