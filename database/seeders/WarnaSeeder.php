<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WarnaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warnaList = [
            // 1. Merah
            ['nama_warna' => 'Merah', 'jenis_warna' => 'Solid', 'kode_hex' => '#FF0000'],
            ['nama_warna' => 'Merah', 'jenis_warna' => 'Marun', 'kode_hex' => '#800000'],
            ['nama_warna' => 'Merah', 'jenis_warna' => 'Candy Tone', 'kode_hex' => '#D2042D'],
            ['nama_warna' => 'Merah', 'jenis_warna' => 'Metalik', 'kode_hex' => '#C41E3A'],
            ['nama_warna' => 'Merah', 'jenis_warna' => 'Matte / Doff', 'kode_hex' => '#A52A2A'],
            ['nama_warna' => 'Merah', 'jenis_warna' => 'Cherry', 'kode_hex' => '#DE3163'],
            ['nama_warna' => 'Merah', 'jenis_warna' => 'Wine', 'kode_hex' => '#722F37'],

            // 2. Biru
            ['nama_warna' => 'Biru', 'jenis_warna' => 'Solid', 'kode_hex' => '#0000FF'],
            ['nama_warna' => 'Biru', 'jenis_warna' => 'Navy', 'kode_hex' => '#000080'],
            ['nama_warna' => 'Biru', 'jenis_warna' => 'Royal', 'kode_hex' => '#4169E1'],
            ['nama_warna' => 'Biru', 'jenis_warna' => 'Metalik', 'kode_hex' => '#3A75C4'],
            ['nama_warna' => 'Biru', 'jenis_warna' => 'Turquoise', 'kode_hex' => '#40E0D0'],
            ['nama_warna' => 'Biru', 'jenis_warna' => 'Matte / Doff', 'kode_hex' => '#2A52BE'],
            ['nama_warna' => 'Biru', 'jenis_warna' => 'Elektrik', 'kode_hex' => '#7DF9FF'],
            ['nama_warna' => 'Biru', 'jenis_warna' => 'Pastel', 'kode_hex' => '#AEC6CF'],

            // 3. Kuning
            ['nama_warna' => 'Kuning', 'jenis_warna' => 'Solid', 'kode_hex' => '#FFFF00'],
            ['nama_warna' => 'Kuning', 'jenis_warna' => 'Emas (Gold)', 'kode_hex' => '#FFD700'],
            ['nama_warna' => 'Kuning', 'jenis_warna' => 'Lemon', 'kode_hex' => '#FFF44F'],
            ['nama_warna' => 'Kuning', 'jenis_warna' => 'Mustard', 'kode_hex' => '#FFDB58'],
            ['nama_warna' => 'Kuning', 'jenis_warna' => 'Neon / Stabilo', 'kode_hex' => '#FFFF33'],
            ['nama_warna' => 'Kuning', 'jenis_warna' => 'Matte / Doff', 'kode_hex' => '#E1AD01'],
            ['nama_warna' => 'Kuning', 'jenis_warna' => 'Pastel', 'kode_hex' => '#FAFAD2'],

            // 4. Hijau
            ['nama_warna' => 'Hijau', 'jenis_warna' => 'Solid', 'kode_hex' => '#008000'],
            ['nama_warna' => 'Hijau', 'jenis_warna' => 'Army', 'kode_hex' => '#4B5320'],
            ['nama_warna' => 'Hijau', 'jenis_warna' => 'Emerald', 'kode_hex' => '#50C878'],
            ['nama_warna' => 'Hijau', 'jenis_warna' => 'Neon / Stabilo', 'kode_hex' => '#39FF14'],
            ['nama_warna' => 'Hijau', 'jenis_warna' => 'Tosca', 'kode_hex' => '#40E0D0'],
            ['nama_warna' => 'Hijau', 'jenis_warna' => 'Lime', 'kode_hex' => '#00FF00'],
            ['nama_warna' => 'Hijau', 'jenis_warna' => 'Matte / Doff', 'kode_hex' => '#006400'],
            ['nama_warna' => 'Hijau', 'jenis_warna' => 'Pastel', 'kode_hex' => '#77DD77'],

            // 5. Hitam
            ['nama_warna' => 'Hitam', 'jenis_warna' => 'Solid', 'kode_hex' => '#000000'],
            ['nama_warna' => 'Hitam', 'jenis_warna' => 'Glossy', 'kode_hex' => '#0A0A0A'],
            ['nama_warna' => 'Hitam', 'jenis_warna' => 'Doff / Matte', 'kode_hex' => '#1C1C1C'],
            ['nama_warna' => 'Hitam', 'jenis_warna' => 'Metalik', 'kode_hex' => '#3B3B3B'],
            ['nama_warna' => 'Hitam', 'jenis_warna' => 'Karbon', 'kode_hex' => '#2B2B2B'],
            ['nama_warna' => 'Hitam', 'jenis_warna' => 'Satin', 'kode_hex' => '#222222'],
            ['nama_warna' => 'Hitam', 'jenis_warna' => 'Pearl', 'kode_hex' => '#1E1E1E'],

            // 6. Putih
            ['nama_warna' => 'Putih', 'jenis_warna' => 'Solid', 'kode_hex' => '#FFFFFF'],
            ['nama_warna' => 'Putih', 'jenis_warna' => 'Glossy', 'kode_hex' => '#FDFDFD'],
            ['nama_warna' => 'Putih', 'jenis_warna' => 'Doff / Matte', 'kode_hex' => '#F5F5F5'],
            ['nama_warna' => 'Putih', 'jenis_warna' => 'Mutiara (Pearl White)', 'kode_hex' => '#F8F8FF'],
            ['nama_warna' => 'Putih', 'jenis_warna' => 'Tulang (Ivory)', 'kode_hex' => '#FFFFF0'],
            ['nama_warna' => 'Putih', 'jenis_warna' => 'Metalik', 'kode_hex' => '#EDEDED'],
            ['nama_warna' => 'Putih', 'jenis_warna' => 'Satin', 'kode_hex' => '#FAFAFA'],

            // 7. Abu-abu
            ['nama_warna' => 'Abu-abu', 'jenis_warna' => 'Solid', 'kode_hex' => '#808080'],
            ['nama_warna' => 'Abu-abu', 'jenis_warna' => 'Glossy', 'kode_hex' => '#A9A9A9'],
            ['nama_warna' => 'Abu-abu', 'jenis_warna' => 'Doff / Matte', 'kode_hex' => '#696969'],
            ['nama_warna' => 'Abu-abu', 'jenis_warna' => 'Metalik', 'kode_hex' => '#B0B0B0'],
            ['nama_warna' => 'Abu-abu', 'jenis_warna' => 'Gelap (Charcoal)', 'kode_hex' => '#36454F'],
            ['nama_warna' => 'Abu-abu', 'jenis_warna' => 'Terang (Silver)', 'kode_hex' => '#C0C0C0'],
            ['nama_warna' => 'Abu-abu', 'jenis_warna' => 'Satin', 'kode_hex' => '#B2BEB5'],
            ['nama_warna' => 'Abu-abu', 'jenis_warna' => 'Pastel', 'kode_hex' => '#D3D3D3'],
        ];

        DB::table('warnas')->insert($warnaList);
    }
}
