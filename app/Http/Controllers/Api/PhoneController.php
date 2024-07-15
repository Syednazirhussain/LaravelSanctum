<?php

namespace App\Http\Controllers\Api;

use App\Models\Phone;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePhoneRequest;
use App\Http\Requests\UpdatePhoneRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PhoneController extends Controller
{
    public function index()
    {
        $phones = Phone::where('user_id', Auth::user()->id)->get();
        
        return response()->json(["phones" => $phones], 200);
    }

    public function store(StorePhoneRequest $request)
    {
        $userId = Auth::user()->id;

        if ($request->active) {
            Phone::where('user_id', $userId)->update(['active' => false]);
        }

        $phone = Phone::create([
            'slug' => $request->input('slug'),
            'code' => $request->input('code'),
            'number' => $request->input('number'),
            'user_id' => $userId,
            'active' => $request->input('active'),
        ]);

        return response()->json(["phone" => $phone], 201);
    }

    public function markAsActive($id)
    {
        $phone = Phone::where('user_id', Auth::user()->id)->find($id);

        if (!$phone) {
            return response()->json(['message' => 'Phone not found'], 404);
        }

        DB::transaction(function () use ($phone) {
            if (!$phone->active) {
                Phone::where('user_id', $phone->user_id)->update(['active' => false]);
            }

            $phone->update(['active' => true]);
        });

        return response()->json(['phone' => $phone], 200);
    }

    public function update(UpdatePhoneRequest $request, $id)
    {
        $phone = Phone::where('user_id', Auth::user()->id)->find($id);

        if (!$phone) {
            return response()->json(['message' => 'Phone not found'], 404);
        }

        if ($request->active) {
            Phone::where('user_id', $phone->user_id)->update(['active' => false]);
        }

        $phone->update($request->validated());

        return response()->json(["phone" => $phone], 200);
    }

    public function destroy($id)
    {
        $phone = Phone::where('user_id', Auth::user()->id)->find($id);

        if (!$phone) {
            return response()->json(['message' => 'Phone not found'], 404);
        }

        $phone->delete();

        return response()->json(['message' => 'Phone deleted']);
    }
}
