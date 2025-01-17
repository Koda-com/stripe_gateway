<?php

namespace kodastripe\StripeWebhook\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class StripeWebhookServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/stripewebhook.php', 'stripewebhook');
    }

    public function boot()
    {
        $this->loadRoutes();
        $this->publishes([
            __DIR__.'/../Config/stripewebhook.php' => config_path('stripewebhook.php'),
        ], 'config');
    }

    protected function loadRoutes()
    {
        Route::group([
            'prefix' => config('stripewebhook.prefix'),
            'middleware' => config('stripewebhook.middleware'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../Http/Routes/routes.php');
        });
    }
}
