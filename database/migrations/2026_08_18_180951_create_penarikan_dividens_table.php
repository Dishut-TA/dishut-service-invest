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
        Schema::create('penarikan_dividens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('investor_id')->comment('Ref -> service-user');
            $table->decimal('nominal_penarikan', 15, 2);
            $table->string('bank_tujuan', 100);
            $table->string('nomor_rekening', 100);
            $table->string('nama_pemilik_rekening', 255);
            $table->enum('status', ['PENDING', 'APPROVED', 'TRANSFERRED', 'REJECTED'])->default('PENDING');
            $table->string('bukti_transfer_bupm_url', 255)->nullable();
            $table->timestamp('tanggal_proses')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penarikan_dividens');
    }
};
