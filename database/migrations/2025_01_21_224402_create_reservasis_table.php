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
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap reservasi
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke user (jika ada fitur user login)
            $table->foreignId('kategori_motor_id')->constrained()->onDelete('cascade'); // Relasi ke jenis motor
            $table->foreignId('tipe_motor_id')->constrained()->onDelete('cascade'); // Relasi ke tipe motor
            $table->json('jenis_repaint_id')->constrained()->onDelete('cascade'); // Relasi ke jenis repaint
            $table->foreignId('penolakan_id')->nullable()->constrained('penolakans')->onDelete('cascade');

            // Relasi ke tabel warnas
            $table->foreignId('warna_body_id')->nullable()->constrained('warnas')->onDelete('set null');
            $table->foreignId('warna_velg_id')->nullable()->constrained('warnas')->onDelete('set null');
            $table->foreignId('warna_knalpot_id')->nullable()->constrained('warnas')->onDelete('set null');
            $table->foreignId('warna_cvt_id')->nullable()->constrained('warnas')->onDelete('set null');

            $table->string('foto_motor')->nullable();
            $table->string('foto_velg')->nullable();
            $table->string('foto_knalpot')->nullable();
            $table->string('foto_cvt')->nullable();

            $table->string('nomor_polisi');
            $table->string('catatan')->nullable();
            $table->decimal('total_harga', 10, 2); // Total harga yang dihitung
            $table->integer('estimasi_waktu'); // Estimasi waktu pengerjaan (dalam hari)
            $table->enum('status', ['pending', 'setuju', 'bongkar', 'cuci', 'amplas', 'dempul', 'epoxy', 'warna', 'permis', 'pasang', 'selesai', 'batal', 'tolak'])->default('pending'); // Status reservasi
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
