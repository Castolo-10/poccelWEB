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

use App\Http\Middleware\LoadSession;
use App\Http\Middleware\SessionRequired;
use App\Http\Middleware\CheckPageSize;
use App\Http\Middleware\CheckProductSortingCriteria;
use App\Http\Middleware\CheckLoginFields;
use App\Http\Middleware\CheckPasswordFields;
use App\Http\Middleware\CheckPaymentFields;


Route::get('/', 'HomeController')
	->middleware(LoadSession::class);

Route::get('/login', function () {
    return View::make('login');
}); // restrict session?

Route::post('/login', 'SessionController@login')
	->middleware(CheckLoginFields::class);

Route::get('/logout', 'SessionController@logout');

Route::get('/catalogo', 'CatalogController@paginate')
	->middleware(
		LoadSession::class,
		CheckPageSize::class,
		CheckProductSortingCriteria::class
	);

Route::post('/mi-cuenta/abonar', 'MyAccountController@credit')
	->middleware(
		LoadSession::class,
		SessionRequired::class,
		CheckPaymentFields::class
	);

Route::get('/mi-cuenta/ver/{accId}/detalles', 'MyAccountController@details')
	->middleware(
		LoadSession::class,
		SessionRequired::class
	);

Route::post('mi-cuenta/cambiar-contrasena', 'MyAccountController@changePassword')
	->middleware(
		LoadSession::class,
		SessionRequired::class,
		CheckPasswordFields::class
		);

Route::get('/mi-cuenta', 'MyAccountController@show')
	->middleware(
		LoadSession::class,
		SessionRequired::class
	);