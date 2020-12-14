<?php

namespace Application\Src\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 * @package Application\Src\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Configs
        $this->app->configure('database');

        // Enable queues
        $this->app->make('queue');

        $this->app->singleton('Illuminate\Contracts\Routing\ResponseFactory', function ($app) {
            return new \Illuminate\Routing\ResponseFactory(
                $app['Illuminate\Contracts\View\Factory'],
                $app['Illuminate\Routing\Redirector']
            );
        });
    }
}
