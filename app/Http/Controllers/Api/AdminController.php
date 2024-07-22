<?php

namespace App\Http\Controllers\Api;

use Exception;

use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;

use App\Events\NewUserEvent;

use App\Http\Requests\AddUserRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function addUser(AddUserRequest $request) 
    {
        DB::beginTransaction();

        try {

            $defaultProfileImage = 'profile-images/default.jpeg';

            if (!Storage::disk('public')->exists($defaultProfileImage)) {
                return response()->json(['message' => 'Default profile image not found'], 500);
            }
            
            $password = Str::random(8);

            $user = User::updateOrCreate(
                ['name' => $request->input('name'), 'password' => Hash::make($password)],
                ['email' => $request->input('email')]
            );

            $role = Role::findOrFail($request->input('role_id'));
            if (!$role) {
                throw new Exception("Role not found");
            }

            $user->roles()->attach($role->id);

            UserProfile::create([
                'user_id'       => $user->id,
                'profile_img'   => $defaultProfileImage,
            ]);

            event(new NewUserEvent($user, $role, $password));

            DB::commit();

            return response()->json(['message' => 'User created successfully'], 201);
        } 
        catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());

            return response()->json();
        }
    }
}
