<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItemCategory;

class MenuItemCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Burgers', 'img' => 'burgers.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sandwitches', 'img' => 'sandwitches.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Desserts', 'img' => 'desserts.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Beverages', 'img' => 'beverages.jpg', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($categories as $category) {
            MenuItemCategory::create($category);
        }
    }
}
