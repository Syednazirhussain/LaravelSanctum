<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::where('role_name', 'Admin')->first();
        $chefRole = Role::where('role_name', 'Chef')->first();
        $waiterRole = Role::where('role_name', 'Waiter')->first();
        $customerRole = Role::where('role_name', 'Customer')->first();

        $users = [
            ['name' => 'Admin User', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Chef User', 'email' => 'chef@example.com', 'password' => Hash::make('password'), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Waiter User', 'email' => 'waiter@example.com', 'password' => Hash::make('password'), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Customer User 1', 'email' => 'customer1@example.com', 'password' => Hash::make('password'), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Customer User 2', 'email' => 'customer2@example.com', 'password' => Hash::make('password'), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Customer User 3', 'email' => 'customer3@example.com', 'password' => Hash::make('password'), 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);
            if ($user->email == 'admin@example.com') {
                $user->roles()->attach($adminRole);
            } elseif ($user->email == 'chef@example.com') {
                $user->roles()->attach($chefRole);
            } elseif ($user->email == 'waiter@example.com') {
                $user->roles()->attach($waiterRole);
            } else {
                $user->roles()->attach($customerRole);
            }
        }
    }
}
