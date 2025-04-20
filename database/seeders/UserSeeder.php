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
        $user = User::create([
            'name' => 'Hype Project',
            'email' => 'hypeproject@gmail.com',
            'phone' => '08123456789',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('user');

    }
}
