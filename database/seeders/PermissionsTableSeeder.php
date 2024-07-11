<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            [
                'permission_name' => 'Manage Users',
                'created_at' => '2024-06-01 10:00:00',
                'updated_at' => '2024-06-15 12:00:00',
            ],
            [
                'permission_name' => 'Manage Menu',
                'created_at' => '2024-06-05 11:00:00',
                'updated_at' => '2024-06-18 13:00:00',
            ],
            [
                'permission_name' => 'View Orders',
                'created_at' => '2024-06-10 12:00:00',
                'updated_at' => '2024-06-20 14:00:00',
            ],
            [
                'permission_name' => 'Manage Orders',
                'created_at' => '2024-06-15 13:00:00',
                'updated_at' => '2024-06-25 15:00:00',
            ],
        ]);
    }
}
