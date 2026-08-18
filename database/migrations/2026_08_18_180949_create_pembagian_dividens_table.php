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
        Schema::create('pembagian_dividens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('laporan_keuangan_id')->constrained('laporan_keuangans')->cascadeOnDelete();
            $table->foreignUuid('program_id')->constrained('program_investasis')->cascadeOnDelete();
            $table->decimal('total_laba_bersih', 15, 2);
            $table->decimal('porsi_kth', 15, 2)->comment('60%');
            $table->decimal('porsi_investor', 15, 2)->comment('40%');
            $table->enum('status_distribusi', ['PENDING', 'DISTRIBUTED'])->default('PENDING');
            $table->timestamp('tanggal_distribusi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembagian_dividens');
    }
};
