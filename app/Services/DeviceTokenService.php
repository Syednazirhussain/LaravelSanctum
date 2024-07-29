<?php

namespace App\Services;

use App\Models\DeviceToken;

class DeviceTokenService
{
    public function addDeviceToken($userId, $type, $token)
    {
        $deviceToken = DeviceToken::updateOrCreate(
            ['user_id' => $userId, 'type' => $type],
            ['token' => $token]
        );

        return $deviceToken;
    }

    public function removeDeviceToken($userId, $type, $token)
    {
        $deviceToken = DeviceToken::where('user_id', $userId)
            ->where('type', $type)
            ->where('token', $token)
            ->first();

        if ($deviceToken) {
            $deviceToken->delete();
            return true;
        }

        return false;
    }
}
