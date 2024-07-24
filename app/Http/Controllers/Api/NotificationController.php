<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index(): JsonResponse
    {
        $notifications = Notification::paginate(10);
        return response()->json(['notifications' => $notifications]);
    }

    public function read($id): JsonResponse
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        $notification->markAsRead();

        return response()->json(['message' => 'Notification marked as read']);
    }

    public function readAll(): JsonResponse
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();

        return response()->json(['message' => 'All notifications marked as read']);
    }
}
