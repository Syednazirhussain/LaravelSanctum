<?php

namespace App\Http\Controllers\Api;

use App\Models\MenuItemCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuItemCategoryRequest;
use App\Http\Requests\UpdateMenuItemCategoryRequest;

class MenuItemCategoryController extends Controller
{
    public function index()
    {
        $categories = MenuItemCategory::all();
        return response()->json(["categories" => $categories]);
    }

    public function store(StoreMenuItemCategoryRequest $request)
    {
        $category = MenuItemCategory::create($request->validated());

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
            return response()->json(['message' => 'Menu Item Category not found'], 404);
        }

        $category->update($request->validated());

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
