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

Route::get('/', 'HomeController');

Route::get('/login', function () {
    return View::make('login');
});

Route::post('/login', 'SessionController@login');

Route::get('/logout', 'SessionController@logout');

Route::get('/forgot-password', function () {
    return View::make('forgot');
});

Route::get('/reset-password', function () {
    return View::make('reset');
});

Route::get('/catalogo', 'CatalogController@paginate');

Route::get('/mi-cuenta', 'MyAccountController@profile');

