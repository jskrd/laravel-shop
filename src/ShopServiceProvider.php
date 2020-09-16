<?php

namespace Jskrd\Shop;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ShopServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configure();

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../config/shop.php' => config_path('shop.php'),
        ]);

        $this->registerRoutes();
    }

    protected function configure(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/shop.php', 'shop');
    }

    public function register(): void
    {
        //
    }

    protected function registerRoutes(): void
    {
        Route::middleware('api')
            ->namespace('Jskrd\Shop\Http\Controllers\Api')
            ->prefix(config('shop.api_path'))
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
            });
    }
}
