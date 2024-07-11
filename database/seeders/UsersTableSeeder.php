<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'alice',
                'password' => Hash::make('password'),
                'email' => 'alice@example.com',
                'created_at' => '2024-06-01 10:00:00',
                'updated_at' => '2024-06-15 12:00:00',
            ],
            [
                'username' => 'bob',
                'password' => Hash::make('password'),
                'email' => 'bob@example.com',
                'created_at' => '2024-06-05 11:00:00',
                'updated_at' => '2024-06-18 13:00:00',
            ],
            [
                'username' => 'charlie',
                'password' => Hash::make('password'),
                'email' => 'charlie@example.com',
                'created_at' => '2024-06-10 12:00:00',
                'updated_at' => '2024-06-20 14:00:00',
            ],
        ]);
    }
}
