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

Route::post('/login', 'AuthController@login')->name('login.post');
Route::post('/register', 'AuthController@register')->name('register.post');
Route::post('/logout', 'AuthController@logout')->name('logout');

Route::get('/', 'MainController@index')->name('home');
Route::get('/exchange', 'MainController@exchange')->name('exchange');

Route::get('/register', 'AuthController@registerView')->name('register');
Route::get('/login', 'AuthController@loginView')->name('login');
Route::get('/account', 'AccountController@show')->name('account');
Route::get('/portfolio', 'PortfolioController@showbalance')->name('portfolio');