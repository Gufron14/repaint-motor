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
        Schema::create('kategori_motors', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori'); // e.g., "Motor 4 Tak", "Motor 2 Tak", "Motor Matic"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_motors');
    }
};
