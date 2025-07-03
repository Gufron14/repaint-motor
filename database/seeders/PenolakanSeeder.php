<?php

namespace Database\Seeders;

use App\Models\Penolakan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenolakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $alasanPenolakan = [
            // Admin reasons
            ['keterangan' => 'Dokumen yang diperlukan belum lengkap atau tidak sesuai', 'tipe' => 'admin'],
            ['keterangan' => 'Jadwal workshop sudah penuh untuk periode yang diminta', 'tipe' => 'admin'],
            ['keterangan' => 'Identitas Alamat Tidak Lengkap atau Nomor Rekening/E-Wallet tidak Valid', 'tipe' => 'admin'],
            ['keterangan' => 'Bukti pembayaran DP tidak valid atau bermasalah', 'tipe' => 'admin'],
            ['keterangan' => 'Dibatalkan otomatis', 'tipe' => 'admin'],

            // Customer reasons
            ['keterangan' => 'Berubah pikiran, tidak jadi repaint', 'tipe' => 'customer'],
            ['keterangan' => 'Ada keperluan mendadak', 'tipe' => 'customer'],
            ['keterangan' => 'Tidak cocok dengan estimasi waktu', 'tipe' => 'customer'],
            ['keterangan' => 'Menemukan bengkel lain yang lebih murah', 'tipe' => 'customer'],
            ['keterangan' => 'Kondisi keuangan tidak memungkinkan', 'tipe' => 'customer'],
        ];

        foreach ($alasanPenolakan as $alasan) {
            Penolakan::create($alasan);
        }
    }
}
