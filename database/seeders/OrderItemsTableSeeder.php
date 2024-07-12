<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;

class OrderItemsTableSeeder extends Seeder
{
    public function run()
    {
        // Ensure the orders and menu items exist before creating order items
        $orders = Order::all();
        $menuItems = MenuItem::all();

        if ($orders->count() == 0 || $menuItems->count() == 0) {
            $this->command->info('No orders or menu items found, skipping order items seeding.');
            return;
        }

        $orderItems = [
            ['order_id' => $orders[0]->id, 'item_id' => $menuItems[0]->id, 'quantity' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => $orders[0]->id, 'item_id' => $menuItems[1]->id, 'quantity' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => $orders[1]->id, 'item_id' => $menuItems[1]->id, 'quantity' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => $orders[2]->id, 'item_id' => $menuItems[2]->id, 'quantity' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($orderItems as $orderItem) {
            OrderItem::create($orderItem);
        }
    }
}
