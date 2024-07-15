<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserProfile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function currentUser(): JsonResponse
    {
        $user_id = auth()->user()->id;
        $user = User::whereId($user_id)->with(['profile', 'phone', 'address'])->first();

        return response()->json(["user" => $user]);
    }


    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = Auth::user();

        $profile = UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            $request->validated()
        );

        if ($request->hasFile('profile_img')) {
            $profileImgPath = $request->file('profile_img')->store('profile-images', 'public');
            $profile->profile_img = $profileImgPath;
            $profile->save();
        }

        // $user = User::whereId($profile->user_id)->with('profile')->first();

        // return response()->json(["user" => $user], 200);

        $profile = UserProfile::where('user_id', $user->id)->with('user')->first();

        return response()->json(["profile" => $profile], 200);
    }
}
