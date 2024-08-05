<?php

namespace App\Services;

use App\Models\DeviceToken;
use App\Contracts\DeviceTokenServiceInterface;

class DeviceTokenService implements DeviceTokenServiceInterface
{
    public function addDeviceToken(int $userId, string $type, string $token): DeviceToken
    {
        $deviceToken = DeviceToken::updateOrCreate(
            ['user_id' => $userId, 'type' => $type, 'token' => $token],
            ['created_at' => now()]
        );

        return $deviceToken;
    }

    public function removeDeviceToken(int $userId, string $type, string $token): bool
    {
        return DeviceToken::where('user_id', $userId)
            ->where('token', $token)
            ->delete() > 0;
    }
}
