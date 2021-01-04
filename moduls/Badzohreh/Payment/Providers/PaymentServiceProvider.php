<?php

namespace Badzohreh\Payment\Providers;

use Badzohreh\Payment\Gateways\Gateway;
use Badzohreh\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    private $namespace = "Badzohreh\Payment\Http\Controllers";

    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . "./../Database/Migrations");
        Route::middleware("web")
            ->namespace($this->namespace)
            ->group(__DIR__ . "./../Routes/payment-routes.php");
    }

    public function boot()
    {
        $this->app->singleton(Gateway::class, function ($app) {
            return new ZarinpalAdaptor();

        });

    }

}
