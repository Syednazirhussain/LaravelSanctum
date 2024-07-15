<?php

namespace App\Http\Controllers\Api;

use App\Models\MenuItem;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;

use Illuminate\Support\Facades\Storage;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::all();
        return response()->json(["menuItems" => $menuItems], 200);
    }

    public function store(StoreMenuItemRequest $request)
    {
        $imagePath = $request->file('img')->store('menu-items', 'public');
        
        $menuItem = MenuItem::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'item_category_id' => $request->input('item_category_id'),
            'img' => $imagePath,
        ]);

        return response()->json(["menuItem" => $menuItem], 201);
    }

    public function show($id)
    {
        $menuItem = MenuItem::find($id);

        if (!$menuItem) {
            return response()->json(['message' => 'Menu Item not found'], 404);
        }

        return response()->json(["menuItem" => $menuItem], 200);
    }

    public function update(UpdateMenuItemRequest $request, $id)
    {
        $menuItem = MenuItem::find($id);

        if (!$menuItem) {
            return response()->json(['message' => 'Menu Item not found'], 404);
        }

        if ($request->hasFile('img')) {
            if ($menuItem->img) {
                Storage::disk('public')->delete($menuItem->img);
            }

            $imagePath = $request->file('img')->store('menu-items', 'public');
            $menuItem->img = $imagePath;
        }

        $menuItem->update($request->only('name', 'price', 'item_category_id'));

        return response()->json(["menuItem" => $menuItem], 200);
    }

    public function destroy($id)
    {
        $menuItem = MenuItem::find($id);

        if (!$menuItem) {
            return response()->json(['message' => 'Menu Item not found'], 404);
        }

        if ($menuItem->img) {
            Storage::disk('public')->delete($menuItem->img);
        }

        $menuItem->delete();

        return response()->json(['message' => 'Menu Item deleted']);
    }
}
