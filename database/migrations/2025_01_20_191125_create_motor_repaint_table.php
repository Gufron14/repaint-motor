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
        Schema::create('motor_repaint', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipe_motor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('jenis_repaint_id')->constrained()->cascadeOnDelete();
            $table->decimal('harga', 10, 2);
            $table->string('estimasi_waktu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motor_repaint');
    }
};
