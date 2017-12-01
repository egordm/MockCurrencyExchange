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

Route::post('/login', 'LoginController@login')->name('api.login');
Route::post('/login/refresh', 'LoginController@refresh')->name('api.refresh');

Route::group(['middleware' => 'auth:api'], function () {
	Route::post('/logout', 'LoginController@logout')->name('api.logout');

	Route::get('/user', function (Request $request) {
		return $request->user();
	});
});
