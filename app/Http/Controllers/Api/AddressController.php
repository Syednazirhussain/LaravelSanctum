<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())->with('user')->paginate(5);

        return response()->json(["addresses" => $addresses], 200);
    }

    public function store(StoreAddressRequest $request)
    {
        $userId = Auth::id();

        // Ensure only one active address per user
        if ($request->active) {
            Address::where('user_id', $userId)->update(['active' => false]);
        }

        $address = Address::create([
            'user_id' => $userId,
            'line_address_1' => $request->line_address_1,
            'line_address_2' => $request->line_address_2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'active' => $request->active,
        ]);

        return response()->json(["address" => $address], 201);
    }

    public function update(UpdateAddressRequest $request, $id)
    {
        $address = Address::where('user_id', Auth::id())->find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        // Ensure only one active address per user
        if ($request->active) {
            Address::where('user_id', $address->user_id)->update(['active' => false]);
        }

        $address->update($request->validated());

        return response()->json(["address" => $address], 200);
    }

    public function destroy($id)
    {
        $address = Address::where('user_id', Auth::id())->find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $address->delete();

        return response()->json(['message' => 'Address deleted']);
    }

    public function markAsActive($id)
    {
        $address = Address::where('user_id', Auth::user()->id)->find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        DB::transaction(function () use ($address) {
            if (!$address->active) {
                Address::where('user_id', $address->user_id)->update(['active' => false]);
            }

            $address->update(['active' => true]);
        });

        return response()->json(['address' => $address], 200);
    }
}
