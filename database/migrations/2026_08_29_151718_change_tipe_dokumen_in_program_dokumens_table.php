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
        Schema::table('program_dokumens', function (Blueprint $table) {
            $table->string('tipe_dokumen', 100)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_dokumens', function (Blueprint $table) {
            $table->enum('tipe_dokumen', ['COVER_IMAGE', 'PROPOSAL_BISNIS', 'LEGALITAS', 'TEMPLATE_PERJANJIAN'])->change();
        });
    }
};
