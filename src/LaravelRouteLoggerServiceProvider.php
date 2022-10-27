<?php

namespace Usmonaliyev\LaravelRouteLogger;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Usmonaliyev\LaravelRouteLogger\Middleware\Log;

class LaravelRouteLoggerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-route-logger.php', 'laravel-route-logger');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-route-logger.php' => config_path('laravel-route-logger.php'),
            ]);
        }

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('laravel-route-logger', Log::class);
    }
}
