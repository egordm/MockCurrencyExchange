<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	    \Schema::defaultStringLength(191);

	    if (\App::environment('local')) {
		    // The environment is local
		    \DB::enableQueryLog();
	    }
        //

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
	    if ($this->app->environment() !== 'production') {
		    $this->app->register(IdeHelperServiceProvider::class);
	    }
	    $this->app->register(RepositoryServiceProvider::class);
        //
    }
}
