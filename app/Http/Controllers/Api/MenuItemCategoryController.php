<?php

namespace App\Http\Controllers\Api;

use App\Models\MenuItemCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuItemCategoryRequest;
use App\Http\Requests\UpdateMenuItemCategoryRequest;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MenuItemCategoryController extends Controller
{
    public function index()
    {
        $categories = MenuItemCategory::all();
        return response()->json(["categories" => $categories]);
    }

    public function store(StoreMenuItemCategoryRequest $request)
    {
        $imagePath = $request->file('img')->store('menu-item-category', 'public');

        $category = MenuItemCategory::create([
            'name' => $request->input('name'),
            'img' => $imagePath,
        ]);

        return response()->json(["category" => $category], 201);
    }

    public function show($id)
    {
        $category = MenuItemCategory::find($id);

        if (!$category) {
            return response()->json(['message' => 'Menu Item Category not found'], 404);
        }

        return response()->json(["category" => $category], 200);
    }

    public function update(UpdateMenuItemCategoryRequest $request, $id)
    {
        $category = MenuItemCategory::find($id);

        if (!$category) {
            return response()->json(['message' => 'MenuItemCategory not found'], 404);
        }

        if ($request->hasFile('img')) {
            if ($category->img) {
                Storage::disk('public')->delete($category->img);
            }

            $imagePath = $request->file('img')->store('menu-item-category', 'public');
            $category->img = $imagePath;
        }

        // Log::info($request->only('name'));

        $category->update($request->only('name'));

        return response()->json(["category" => $category], 200);
    }

    public function destroy($id)
    {
        $category = MenuItemCategory::find($id);

        if (!$category) {
            return response()->json(['message' => 'Menu Item Category not found'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Menu Item Category deleted'], 200);
    }
}
