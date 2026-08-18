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
        Schema::create('program_investasis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->comment('Mewakili entitas KTH dari service-user');
            $table->string('nama_program', 255);
            $table->string('kategori_usaha', 100);
            $table->decimal('target_dana', 15, 2);
            $table->decimal('dana_terkumpul', 15, 2)->default(0);
            $table->decimal('persentase_keuntungan', 5, 2)->comment('Estimasi RoI');
            $table->integer('periode_kontrak_bulan');
            $table->timestamp('batas_waktu_pengumpulan')->nullable();
            $table->text('deskripsi');
            $table->enum('status', ['DRAFT', 'WAITING_STAFF_VERIFICATION', 'REVISION', 'WAITING_HEAD_APPROVAL', 'ACTIVE', 'FUNDED', 'COMPLETED'])->default('DRAFT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_investasis');
    }
};
