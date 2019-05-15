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


Route::get('/', 'HomeController')
	->middleware(LoadSession::class);

Route::get('/login', function () {
    return View::make('login');
}); // restrict session?

Route::post('/login', 'SessionController@login')
	->middleware(CheckLoginFields::class);

Route::get('/logout', 'SessionController@logout');

Route::get('/forgot-password', function () {
    return View::make('forgot');
}); // restrict session?

Route::get('/reset-password', function () {
    return View::make('reset');
});

Route::post('mi-cuenta/cambiar-contrasena', 'MyAccountController@changePassword')
	->middleware(
		LoadSession::class,
		SessionRequired::class,
		CheckPasswordFields::class
		);

Route::get('/catalogo', 'CatalogController@paginate')
	->middleware(
		LoadSession::class,
		CheckPageSize::class,
		CheckProductSortingCriteria::class
	);

Route::get('/mi-cuenta', 'MyAccountController@profile')
	->middleware(
		LoadSession::class,
		SessionRequired::class
	);

