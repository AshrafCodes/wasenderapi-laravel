<?php

namespace Ashraf\WasenderApi;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class WasenderApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/wasenderapi.php', 'wasenderapi');

        $this->app->singleton(Client::class, fn () => new Client(config('wasenderapi')));
        $this->app->singleton(WasenderApi::class, fn ($app) => new WasenderApi($app->make(Client::class)));
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/wasenderapi.php' => config_path('wasenderapi.php'),
        ], 'wasenderapi-config');

        if (config('wasenderapi.webhook_route_enabled')) {
            Route::middleware(config('wasenderapi.webhook_route_middleware', ['api']))
                ->group(__DIR__ . '/../routes/wasenderapi.php');
        }
    }
}
