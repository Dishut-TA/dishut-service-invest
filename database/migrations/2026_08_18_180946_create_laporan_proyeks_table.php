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
        Schema::create('laporan_proyeks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('program_id')->constrained('program_investasis')->cascadeOnDelete();
            $table->foreignUuid('milestone_id')->nullable()->constrained('program_milestones')->nullOnDelete();
            $table->text('deskripsi_kemajuan');
            $table->enum('status_verifikasi', ['PENDING', 'VERIFIED', 'REVISION'])->default('PENDING');
            $table->uuid('verified_by_staff_id')->nullable()->comment('Ref -> service-user');
            $table->text('catatan_verifikasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_proyeks');
    }
};
