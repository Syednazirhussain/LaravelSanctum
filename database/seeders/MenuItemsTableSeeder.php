<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;
use App\Models\MenuItemCategory;

class MenuItemsTableSeeder extends Seeder
{
    public function run()
    {
        $categories = MenuItemCategory::all();

        $menuItems = [
            ['item_category_id' => $categories->where('name', 'Burgers')->first()->id, 'img' => 'spring_rolls.jpg', 'name' => 'Spring Rolls', 'price' => 5.99, 'created_at' => now(), 'updated_at' => now()],
            ['item_category_id' => $categories->where('name', 'Sandwitches')->first()->id, 'img' => 'steak.jpg', 'name' => 'Grilled Steak', 'price' => 19.99, 'created_at' => now(), 'updated_at' => now()],
            ['item_category_id' => $categories->where('name', 'Desserts')->first()->id, 'img' => 'cheesecake.jpg', 'name' => 'Cheesecake', 'price' => 6.99, 'created_at' => now(), 'updated_at' => now()],
            ['item_category_id' => $categories->where('name', 'Beverages')->first()->id, 'img' => 'iced_tea.jpg', 'name' => 'Iced Tea', 'price' => 2.99, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($menuItems as $menuItem) {
            MenuItem::create($menuItem);
        }
    }
}
