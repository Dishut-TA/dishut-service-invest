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
        Schema::create('laporan_keuangans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('program_id')->constrained('program_investasis')->cascadeOnDelete();
            $table->date('periode_awal');
            $table->date('periode_akhir');
            $table->decimal('total_pendapatan', 15, 2);
            $table->decimal('total_pengeluaran', 15, 2);
            $table->decimal('laba_bersih', 15, 2);
            $table->string('bukti_nota_url', 255);
            $table->enum('status_verifikasi', ['PENDING', 'VERIFIED', 'REJECTED'])->default('PENDING');
            $table->uuid('verified_by_staff_id')->nullable()->comment('Ref -> service-user');
            $table->text('catatan_verifikasi')->nullable();
            $table->boolean('is_dividends_distributed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_keuangans');
    }
};
