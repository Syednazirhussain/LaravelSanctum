<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        $customers = User::whereHas('roles', function($query) {
            $query->where('role_name', 'Customer');
        })->get();

        foreach ($customers as $customer) {
            Order::create([
                'user_id' => $customer->id,
                'order_date' => now(),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
