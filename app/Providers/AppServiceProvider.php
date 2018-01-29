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

	    \Validator::extend('old_password', function($attribute, $value, $parameters, $validator) {
		    return \Hash::check($value, \Auth::user()->password);
	    });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
	    require_once __DIR__ . '/../Http/helpers.php';
	    if ($this->app->environment() !== 'production') {
		    $this->app->register(IdeHelperServiceProvider::class);
	    }
	    $this->app->register(RepositoryServiceProvider::class);
    }
}
