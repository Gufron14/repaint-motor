<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->string('snap_token')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_code')->nullable();
            $table->string('pdf_url')->nullable();
        });
    }

    public function down()
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'transaction_id', 'payment_type', 'payment_code', 'pdf_url']);
        });
    }
};
