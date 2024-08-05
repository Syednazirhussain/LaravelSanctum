<?php

namespace App\Contracts;

use App\Models\DeviceToken;

interface DeviceTokenServiceInterface
{
    public function addDeviceToken(int $userId, string $type, string $token): DeviceToken;

    public function removeDeviceToken(int $userId, string $type, string $token): bool;
}
