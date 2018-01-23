<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Auth::routes();

Route::get('/login', 'AuthController@loginView')->name('login');
Route::post('/login', 'AuthController@login')->name('login.post');
Route::get('/register', 'AuthController@registerView')->name('register');
Route::post('/register', 'AuthController@register')->name('register.post');

Route::group(['middleware' => 'auth'], function () {
	Route::post('/logout', 'AuthController@logout')->name('logout');

	Route::get('/account', 'AccountController@edit')->name('account');
	Route::post('/account', 'AccountController@update')->name('account.post');

	Route::get('/portfolio', 'PortfolioController@showbalance')->name('portfolio');
});

Route::get('/', 'MainController@index')->name('home');
Route::get('/exchange', 'MainController@exchange')->name('exchange');




