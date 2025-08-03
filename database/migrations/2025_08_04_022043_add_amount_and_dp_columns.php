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
        Schema::table('payment', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->nullable()->after('reservasi_id'); // Nominal pembayaran
            $table->string('payment_type')->default('dp')->after('amount'); // Jenis pembayaran: dp, additional, final
            $table->text('description')->nullable()->after('payment_type'); // Keterangan pembayaran
            $table->string('snap_token')->nullable()->after('status_pembayaran'); // Token Midtrans
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->dropColumn(['amount', 'payment_type', 'description', 'snap_token']);
        });
    }
};
