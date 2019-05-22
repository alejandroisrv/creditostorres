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
    return view('welcome');
});
Route::get('/example/{id?}/{d?}', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('welcome');
});

Route::get('/inventario/{id?}/{d?}', function () {
    return view('welcome');
});
Route::get('/clientes', function () {
    return view('welcome');
});
Route::get('/sucursales/{id?}/{d?}', function () {
    return view('welcome');
});

Route::get('/bodegas/{id?}/{d?}', function () {
    return view('welcome');
});

Route::get('/ventas/{id?}', function () {
    return view('welcome');
});