<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'hyperproject@admin.com',
            'phone' => '08123456780',
            'password' => bcrypt('password')
        ]);

        $admin->assignRole('admin');
    }
}
