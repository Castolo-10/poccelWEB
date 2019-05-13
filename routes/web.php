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

Route::get('/', function () {
    return View::make('home');
});

Route::get('/login', function () {
    return View::make('login');
});

Route::post('/login', 'SessionCtrl@login');

Route::get('/logout', 'SessionCtrl@logout');

Route::get('/forgot-password', function () {
    return View::make('forgot');
});

Route::get('/reset-password', function () {
    return View::make('reset');
});

Route::get('/catalog', function () {
    return View::make('catalog');
});

Route::get('/my-account', function () {
    return View::make('account');
});

