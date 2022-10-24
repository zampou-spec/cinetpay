<?php

namespace Zampou\CinetPay\Providers;

use Zampou\CinetPay\CinetPay;
use Illuminate\Support\ServiceProvider;

class CinetPayProvider extends ServiceProvider
{
    const SINGLETON = 'cinetpay';

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'cinetpay');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('cinetpay.php'),
            ], 'cinetpay');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(self::SINGLETON, function () {
            return new CinetPay();
        });
    }
}
