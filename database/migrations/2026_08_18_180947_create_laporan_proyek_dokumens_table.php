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
        Schema::create('laporan_proyek_dokumens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('laporan_proyek_id')->constrained('laporan_proyeks')->cascadeOnDelete();
            $table->string('file_url', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_proyek_dokumens');
    }
};
