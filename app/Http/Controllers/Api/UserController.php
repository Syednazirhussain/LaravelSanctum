<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function currentUser(Request $request): JsonResponse
    {
        $user_id = auth()->user()->id;
        $user = User::whereId($user_id)->with(['roles', 'phone', 'address'])->first();

        return response()->json(["user" => $user]);
    }
}
