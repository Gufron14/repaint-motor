<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Buat Role
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleUser = Role::create(['name' => 'user']);

        // Buat Permission untuk Admin
        Permission::create(['name' => 'access.admin.dashboard']);
        Permission::create(['name' => 'manage.portfolios']);
        Permission::create(['name' => 'manage.reservations']);
        Permission::create(['name' => 'manage.users']);

        // Buat Permission untuk User
        Permission::create(['name' => 'create.reservation']);
        Permission::create(['name' => 'view.own.reservation']);

        // Assign Permission ke Role Admin
        $roleAdmin->givePermissionTo([
            'access.admin.dashboard',
            'manage.portfolios',
            'manage.reservations', 
            'manage.users'
        ]);

        // Assign Permission ke Role User
        $roleUser->givePermissionTo([
            'create.reservation',
            'view.own.reservation',
        ]);
    }
}
