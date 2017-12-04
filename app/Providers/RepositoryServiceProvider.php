<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\OrderRepository::class, \App\Repositories\OrderRepository::class);
        $this->app->bind(\App\Repositories\ValutaPairRepository::class, \App\Repositories\ValutaPairRepository::class);
        $this->app->bind(\App\Repositories\OrderFillRepository::class, \App\Repositories\OrderFillRepository::class);
        //:end-bindings:
    }
}
