<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', 'AuthController@login')->name('api.login');
Route::post('/login/refresh', 'AuthController@refresh')->name('api.refresh');

Route::group(['middleware' => 'multi-auth'], function () {
	Route::post('/logout', 'AuthController@logout')->middleware('guest')->name('api.logout');

	Route::get('/user', function (Request $request) {
		return $request->user();
	});

	Route::get('/balance', 'BalanceController@index')->name('api.balance');

	Route::prefix('order')->group(function () {
		Route::get('/', 'OrdersController@index');
		Route::get('/{id}', 'OrdersController@view');
		Route::post('/create', 'OrdersController@create');
	});

	Route::group(['prefix' => 'market'], function () {
		Route::get('/', 'MarketController@index');
	});
});
