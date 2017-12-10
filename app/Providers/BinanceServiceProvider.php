<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 10-12-2017
 * Time: 19:19
 */

namespace App\Providers;


use App\External\BinanceAPI;
use Illuminate\Support\ServiceProvider;

class BinanceServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind(BinanceAPI::class, function ($app) {
			return new BinanceAPI();
		});
	}
}