<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'Manage Users', 'code' => 'manage_users'],
            ['name' => 'View Menu', 'code' => 'view_menu'],
            ['name' => 'Create Orders', 'code' => 'create_orders'],
            ['name' => 'Manage Menu Items', 'code' => 'manage_menu_items'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission['name']], $permission);
        }
    }
}
