<?php

use App\Models\TipeMotor;
use App\Models\JenisRepaint;
use App\Models\MotorRepaint;
use App\Models\KategoriMotor;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\PenolakanSeeder;
use Database\Seeders\RoleAndPermissionSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Jalankan RoleAndPermissionSeeder terlebih dahulu
        // agar role dan permission sudah tersedia saat membuat user
        $this->call(RoleAndPermissionSeeder::class);

        // Kemudian jalankan UserSeeder
        $this->call(UserSeeder::class);

        $this->call(PenolakanSeeder::class);

        // $this->call([
        //     RoleAndPermissionSeeder::class,
        //     AdminSeeder::class
        // ]);

        // Data kategori, tipe motor, dan jenis repaint
        $dataKategori = [
            'Manual' => [
                'tipe_motor' => [
                    'Supra X',
                    'Vega ZR',
                    'Jupiter Z',
                    'Beat Karbu',
                ],
                'jenis_repaint' => [['nama' => 'Full Body', 'harga' => 700000, 'estimasi' => '7 hari'], ['nama' => 'Body Halus', 'harga' => 500000, 'estimasi' => '5 hari'], ['nama' => 'Body Kasar', 'harga' => 200000, 'estimasi' => '5 hari'], ['nama' => 'Velg', 'harga' => 250000, 'estimasi' => '1 hari'], ['nama' => 'Knalpot', 'harga' => 50000, 'estimasi' => '1 hari']],
            ],
            'Kopling' => [
                'tipe_motor' => [
                    'RX King' => [['nama' => 'Full body', 'harga' => 700000, 'estimasi' => '7 hari'], ['nama' => 'Velg', 'harga' => 300000, 'estimasi' => '1 hari'], ['nama' => 'Knalpot', 'harga' => 50000, 'estimasi' => '1 hari']],
                    'Ninja R' => [['nama' => 'Full body', 'harga' => 700000, 'estimasi' => '7 hari'], ['nama' => 'Velg', 'harga' => 300000, 'estimasi' => '1 hari'], ['nama' => 'Knalpot', 'harga' => 50000, 'estimasi' => '1 hari']],
                    'Ninja RR' => [['nama' => 'Full body', 'harga' => 1000000, 'estimasi' => '7 hari'], ['nama' => 'Velg', 'harga' => 300000, 'estimasi' => '1 hari'], ['nama' => 'Knalpot', 'harga' => 50000, 'estimasi' => '1 hari']],
                    'Vixion',
                    'CB 150 R',
                    'CBR 150', // 150cc kopling
                    'R15',
                    'R25', // 250cc kopling
                ],
                'jenis_repaint' => [['nama' => 'Full Body', 'harga' => 850000, 'estimasi' => '7 hari'], ['nama' => 'Body Halus', 'harga' => 600000, 'estimasi' => '5 hari'], ['nama' => 'Body Kasar', 'harga' => 250000, 'estimasi' => '5 hari'], ['nama' => 'Velg', 'harga' => 350000, 'estimasi' => '1 hari'], ['nama' => 'Knalpot', 'harga' => 50000, 'estimasi' => '1 hari']],
            ],
            'Matic' => [
                'tipe_motor' => ['Vario 125 Old', 'Vario 150 Old', 'Vario 125 New', 'Vario 150 New', 'Xeon', 'Soul GT', 'Lexy', 'N-Max', 'Vario 160', 'PCX 150 Old', 'PCX 160', 'Scoopy Old', 'Scoopy New', 'Genio', 'Fazio', 'Filano', 'ESP', 'Mio', 'Mio 3',],
                'jenis_repaint' => [['nama' => 'Full Body', 'harga' => 950000, 'estimasi' => '7 hari'], ['nama' => 'Body Halus', 'harga' => 700000, 'estimasi' => '5 hari'], ['nama' => 'Body Kasar', 'harga' => 250000, 'estimasi' => '5 hari'], ['nama' => 'Velg', 'harga' => 250000, 'estimasi' => '1 hari'], ['nama' => 'Knalpot', 'harga' => 50000, 'estimasi' => '1 hari'], ['nama' => 'CVT', 'harga' => 100000, 'estimasi' => '1 hari']],
            ],
        ];

        // Proses memasukkan data ke database
        foreach ($dataKategori as $namaKategori => $data) {
            $kategori = KategoriMotor::create(['nama_kategori' => $namaKategori]);

            foreach ($data['tipe_motor'] as $tipe => $jenisRepaints) {
                if (is_array($jenisRepaints)) {
                    $namaTipeMotor = $tipe;
                } else {
                    $namaTipeMotor = $jenisRepaints;
                    $jenisRepaints = $data['jenis_repaint'];
                }

                $tipeMotor = TipeMotor::create([
                    'kategori_motor_id' => $kategori->id,
                    'nama_motor' => $namaTipeMotor,
                ]);

                foreach ($jenisRepaints as $jenis) {
                    $jenisRepaint = JenisRepaint::firstOrCreate(['nama_repaint' => $jenis['nama']]);

                    MotorRepaint::create([
                        'tipe_motor_id' => $tipeMotor->id,
                        'jenis_repaint_id' => $jenisRepaint->id,
                        'harga' => $jenis['harga'],
                        'estimasi_waktu' => $jenis['estimasi'],
                    ]);
                }
            }
        }
    }
}
