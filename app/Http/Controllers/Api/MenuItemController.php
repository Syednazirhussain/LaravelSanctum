<?php

namespace App\Http\Controllers\Api;

use App\Models\MenuItem;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::all();
        return response()->json(["menuItems" => $menuItems], 200);
    }

    public function store(StoreMenuItemRequest $request)
    {
        $menuItem = MenuItem::create($request->validated());

        return response()->json($menuItem, 201);
    }

    public function show($id)
    {
        $menuItem = MenuItem::find($id);

        if (!$menuItem) {
            return response()->json(['message' => 'MenuItem not found'], 404);
        }

        return response()->json($menuItem);
    }

    public function update(UpdateMenuItemRequest $request, $id)
    {
        $menuItem = MenuItem::find($id);

        if (!$menuItem) {
            return response()->json(['message' => 'MenuItem not found'], 404);
        }

        $menuItem->update($request->validated());

        return response()->json($menuItem);
    }

    public function destroy($id)
    {
        $menuItem = MenuItem::find($id);

        if (!$menuItem) {
            return response()->json(['message' => 'MenuItem not found'], 404);
        }

        $menuItem->delete();

        return response()->json(['message' => 'MenuItem deleted']);
    }
}
