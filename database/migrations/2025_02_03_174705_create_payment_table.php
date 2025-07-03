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
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservasi_id')->constrained()->onDelete('cascade');
            $table->string('metode_pembayaran');
            $table->string('status_pembayaran')->default('belum bayar');
            $table->string('bukti_pembayaran');
            $table->string('bukti_pengembalian')->nullable();
            $table->boolean('status_pengembalian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
