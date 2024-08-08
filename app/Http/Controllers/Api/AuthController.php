<?php

namespace App\Http\Controllers\Api;

use Exception;

use App\Models\User;
use App\Models\Role;
use App\Models\UserProfile;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterationRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ForgotPasswordResetRequest;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Events\Registered;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(RegisterationRequest $request): JsonResponse
    {
        $defaultProfileImage = 'profile-images/default.jpeg';

        if (!Storage::disk('public')->exists($defaultProfileImage)) {
            return response()->json(['message' => 'Default profile image not found'], 500);
        }

        DB::beginTransaction();

        try {
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password)
            ]);

            $role = Role::where('code', 'customer')->first();
            if ($role) {
                $user->roles()->attach($role->id);
            }

            UserProfile::create([
                'user_id'       => $user->id,
                'profile_img'   => $defaultProfileImage,
            ]);

            event(new Registered($user));

            DB::commit();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'data'          => $user,
                'access_token'  => $token,
                'token_type'    => 'Bearer'
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['message' => 'Registration failed'], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }


        $user   = User::where('email', $request->email)->firstOrFail();
        $token  = $user->createToken('auth_token', ['*'])->plainTextToken;

        return response()->json([
            'message'       => 'Login success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return response()->json(["message" => "Logout successfull"]);
    }

    public function verifyEmail(Request $request, $id, $hash): JsonResponse
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid verification link'], 400);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 400);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json(['message' => 'Email verified successfully']);
    }

    public function resendVerificationEmail(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 400);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification email resent']);
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Reset link sent to your email']);
        }

        return response()->json(['message' => 'Unable to send reset link'], 500);
    }

    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPasswordWithToken(ForgotPasswordResetRequest $request): JsonResponse
    {    
        $status = Password::reset(
            $request->only('email', 'token', 'password', 'password_confirmation'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );
    
        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password has been reset successfully']);
        }
    
        return response()->json(['message' => 'Unable to reset password'], 500);
    }
    
}
