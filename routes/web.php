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
    return view('welcome1');
});
Route::get('/user/{id}', 'User\BasicController@show');
Route::get('/products', 'ProductsController@showAll')->name('products');
Route::get('/cart', 'CartController@show')->name('cart');
Route::post('/cart/add', 'CartController@add');
Route::post('/cart/remove', 'CartController@remove');
Route::post('/cart/clear', 'CartController@clear');