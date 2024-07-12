<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            UsersTableSeeder::class,
            MenuItemCategoriesTableSeeder::class,
            MenuItemsTableSeeder::class,
            OrdersTableSeeder::class,
            OrderItemsTableSeeder::class,
        ]);
    }
}
