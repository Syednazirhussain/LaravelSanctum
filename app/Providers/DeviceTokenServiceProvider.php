<?php

namespace App\Providers;

use App\Services\DeviceTokenService;
use Illuminate\Support\ServiceProvider;

class DeviceTokenServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(DeviceTokenService::class, function ($app) {
            return new DeviceTokenService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
