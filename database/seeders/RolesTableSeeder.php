<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['role_name' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['role_name' => 'Chef', 'created_at' => now(), 'updated_at' => now()],
            ['role_name' => 'Waiter', 'created_at' => now(), 'updated_at' => now()],
            ['role_name' => 'Customer', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
        
        /*
        DB::table('roles')->insert([
            [
                'role_name' => 'Admin',
                'created_at' => '2024-06-01 10:00:00',
                'updated_at' => '2024-06-15 12:00:00',
            ],
            [
                'role_name' => 'Chef',
                'created_at' => '2024-06-05 11:00:00',
                'updated_at' => '2024-06-18 13:00:00',
            ],
            [
                'role_name' => 'Waitstaff',
                'created_at' => '2024-06-10 12:00:00',
                'updated_at' => '2024-06-20 14:00:00',
            ],
        ]);
        */
    }
}
