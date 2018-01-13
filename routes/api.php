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

	Route::prefix('balance')->group(function () {
		Route::get('/{symbols?}', 'BalanceController@index')->name('api.balance');
	});


	Route::prefix('orders')->group(function () {
		Route::get('/', 'OrdersController@index')->name('orders');
		Route::post('/create', 'OrdersController@create')->name('orders.create');
		Route::get('/{id}', 'OrdersController@view')->name('orders.view');
		Route::post('/{id}/cancel', 'OrdersController@cancel')->name('orders.cancel');
	});
});

Route::group(['prefix' => 'markets'], function () {
	Route::get('/', 'MarketController@index')->name('markets');
	Route::get('/{market}', 'MarketController@view')->name('markets.view');
	Route::get('/{market}/depth', 'MarketController@depth')->name('markets.depth');
	Route::get('/{market}/history', 'MarketController@history')->name('markets.history');
	Route::get('/{market}/candlesticks', 'MarketController@candlesticks')->name('markets.candlesticks');
	Route::get('/{market}/poll', 'MarketController@poll')->name('markets.poll');
});
