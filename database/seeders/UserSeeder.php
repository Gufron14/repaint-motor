<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat admin
        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'phone' => '08123456780',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        // Buat user biasa
        $user = User::create([
            'name' => 'Habib Hakim Permana',
            'username' => 'hakim',
            'phone' => '08123456789',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');
    }
}
