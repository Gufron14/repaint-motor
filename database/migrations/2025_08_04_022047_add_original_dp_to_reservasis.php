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
        Schema::table('reservasis', function (Blueprint $table) {
            $table->decimal('original_total_harga', 10, 2)->nullable()->after('total_harga'); // Total harga awal saat reservasi dibuat
            $table->decimal('original_dp_amount', 10, 2)->nullable()->after('original_total_harga'); // DP awal (10% dari total harga awal)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->dropColumn(['original_total_harga', 'original_dp_amount']);
        });
    }
};
