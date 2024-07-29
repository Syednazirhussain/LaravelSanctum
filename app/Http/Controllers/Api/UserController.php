<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserProfile;

use App\Contracts\DeviceTokenServiceInterface;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\DeviceTokenRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ResetPasswordRequest;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $deviceTokenService;

    public function __construct(DeviceTokenServiceInterface $deviceTokenService)
    {
        $this->deviceTokenService = $deviceTokenService;
    }

    public function currentUser(): JsonResponse
    {
        $user_id = Auth::user()->id;
        $user = User::whereId($user_id)->with(['profile', 'deviceTokens', 'phone', 'address', 'roles'])->first();

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

        $profile = UserProfile::where('user_id', $user->id)->with('user')->first();

        return response()->json(["profile" => $profile], 200);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 403);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return response()->json(['message' => 'Password reset successful']);
    }

    public function addDeviceToken(DeviceTokenRequest $request): JsonResponse
    {
        $user = Auth::user();

        $deviceToken = $this->deviceTokenService->addDeviceToken($user->id, $request->type, $request->token);

        return response()->json(['message' => 'Device token added successfully', 'deviceToken' => $deviceToken]);
    }

    public function removeDeviceToken(DeviceTokenRequest $request): JsonResponse
    {
        $user = Auth::user();

        $isRemoved = $this->deviceTokenService->removeDeviceToken($user->id, $request->type, $request->token);

        if ($isRemoved) {
            return response()->json(['message' => 'Device token removed successfully']);
        }

        return response()->json(['message' => 'Device token not found'], 404);
    }


}
