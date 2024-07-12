<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Admin', 'code' => 'admin'],
            ['name' => 'Chef', 'code' => 'chef'],
            ['name' => 'Waiter', 'code' => 'waiter'],
            ['name' => 'Customer', 'code' => 'customer'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], $role);
        }
    }
}
