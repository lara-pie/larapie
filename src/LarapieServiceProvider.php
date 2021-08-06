<?php

namespace Larapie\Larapie;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LarapieServiceProvider extends ServiceProvider
{
    /**
     * Larapie Service Provider boot
     */
    public function boot()
    {
        $this->app->bind('larapie', function($app) {
            return new LarapieHelper();
        });

        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'larapie');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/larapie.php' => config_path('larapie.php'),
            ], 'config');
        }
    }

    /**
     * Larapie Service Provider register
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/larapie.php', 'larapie');
    }

    /**
     * @return array
     */
    private function routeConfiguration(): array
    {
        $config = [];

        if (config('larapie.prefix')) {
            $config['prefix'] = config('larapie.prefix');
        }
        if (config('larapie.middleware')) {
            $config['middleware'] = config('larapie.middleware');
        }

        return $config;
    }
}
