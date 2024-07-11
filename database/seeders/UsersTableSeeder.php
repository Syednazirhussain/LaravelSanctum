<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
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
                'name' => 'Alice',
                'email' => 'alice@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('hashed_pw1'),
                'remember_token' => Str::random(10),
                'created_at' => '2024-06-01 10:00:00',
                'updated_at' => '2024-06-15 12:00:00',
            ],
            [
                'name' => 'Bob',
                'email' => 'bob@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('hashed_pw2'),
                'remember_token' => Str::random(10),
                'created_at' => '2024-06-05 11:00:00',
                'updated_at' => '2024-06-18 13:00:00',
            ],
            [
                'name' => 'Charlie',
                'email' => 'charlie@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('hashed_pw3'),
                'remember_token' => Str::random(10),
                'created_at' => '2024-06-10 12:00:00',
                'updated_at' => '2024-06-20 14:00:00',
            ],
        ]);
    }
}
