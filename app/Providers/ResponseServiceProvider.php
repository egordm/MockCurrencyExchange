<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 10-12-2017
 * Time: 16:05
 */

namespace App\Providers;


use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
	public function boot(ResponseFactory $factory)
	{
		$factory->macro('api', function ($data) use ($factory) {

			$customFormat = [
				'success' => true,
				'data' => $data
			];
			return $factory->make($customFormat);
		});
	}

	public function register()
	{
		//
	}
}