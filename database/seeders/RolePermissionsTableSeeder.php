<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_permissions')->insert([
            [
                'role_id' => 1,
                'permission_id' => 1,
                'created_at' => '2024-06-01 10:00:00',
                'updated_at' => '2024-06-15 12:00:00',
            ],
            [
                'role_id' => 1,
                'permission_id' => 2,
                'created_at' => '2024-06-05 11:00:00',
                'updated_at' => '2024-06-18 13:00:00',
            ],
            [
                'role_id' => 1,
                'permission_id' => 3,
                'created_at' => '2024-06-10 12:00:00',
                'updated_at' => '2024-06-20 14:00:00',
            ],
            [
                'role_id' => 1,
                'permission_id' => 4,
                'created_at' => '2024-06-15 13:00:00',
                'updated_at' => '2024-06-25 15:00:00',
            ],
            [
                'role_id' => 2,
                'permission_id' => 2,
                'created_at' => '2024-06-01 10:00:00',
                'updated_at' => '2024-06-15 12:00:00',
            ],
            [
                'role_id' => 2,
                'permission_id' => 3,
                'created_at' => '2024-06-05 11:00:00',
                'updated_at' => '2024-06-18 13:00:00',
            ],
            [
                'role_id' => 3,
                'permission_id' => 3,
                'created_at' => '2024-06-10 12:00:00',
                'updated_at' => '2024-06-20 14:00:00',
            ],
            [
                'role_id' => 3,
                'permission_id' => 4,
                'created_at' => '2024-06-15 13:00:00',
                'updated_at' => '2024-06-25 15:00:00',
            ],
        ]);
    }
}
