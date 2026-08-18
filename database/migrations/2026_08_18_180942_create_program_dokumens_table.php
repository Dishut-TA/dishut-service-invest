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
        Schema::create('program_dokumens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('program_id')->constrained('program_investasis')->cascadeOnDelete();
            $table->enum('tipe_dokumen', ['COVER_IMAGE', 'PROPOSAL_BISNIS', 'LEGALITAS', 'TEMPLATE_PERJANJIAN']);
            $table->string('file_url', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_dokumens');
    }
};
