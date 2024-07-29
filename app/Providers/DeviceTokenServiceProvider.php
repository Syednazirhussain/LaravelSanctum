<?php

namespace App\Providers;

use App\Services\DeviceTokenService;
use App\Contracts\DeviceTokenServiceInterface;

use Illuminate\Support\ServiceProvider;

class DeviceTokenServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(DeviceTokenServiceInterface::class, DeviceTokenService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
