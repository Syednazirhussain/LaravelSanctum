<?php

namespace App\Http\Controllers\Api;

use Exception;

use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;

use App\Events\NewUserEvent;

use App\Http\Requests\AddUserRequest;
use App\Http\Requests\AnnouncementRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use App\Notifications\AnnouncementNotification;
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

    public function sendNotification(AnnouncementRequest $request)
    {
        $subject    = $request->input('subject');
        $message    = $request->input('message');
        $notifyTo   = $request->input('notify_to');
        $notifyVia  = $request->input('notify_via');

        try {
            if ($notifyTo === 'all') {
                $roles = ['chef', 'waiter'];
            } else {
                $roles = [$notifyTo];
            }

            $users = User::whereHas('roles', function($query) use ($roles) {
                $query->whereIn('name', $roles);
            })->get();

            foreach ($users as $user) {
                $user->notify(new AnnouncementNotification($subject, $message, $notifyVia));
            }

            return response()->json(['message' => 'Notifications sent successfully.'], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Failed to send notifications.'], 500);
        }
    }

}
