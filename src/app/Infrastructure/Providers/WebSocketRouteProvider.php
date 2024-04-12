<?php

namespace App\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

class WebSocketRouteProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        require base_path('routes/websockets.php');
    }
}
