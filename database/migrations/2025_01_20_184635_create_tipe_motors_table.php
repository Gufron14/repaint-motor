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
        Schema::create('tipe_motors', function (Blueprint $table) {
            $table->id();
            $table->string('nama_motor'); // e.g., "Supra X", "RX King", "Vario 125"
            $table->foreignId('kategori_motor_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe_motors');
    }
};
