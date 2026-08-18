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
        Schema::create('investor_dividen_wallets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('investor_id')->comment('Ref -> service-user');
            $table->decimal('saldo_dividen', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_dividen_wallets');
    }
};
