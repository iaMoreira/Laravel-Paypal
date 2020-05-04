<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'StoreController@index')->name('home');
Route::get('/carrinho', 'CartController@index')->name('cart');
Route::get('/perfil', 'UserController@profile')->name('profile');
Route::get('/adicionar-carrinho/{product}', 'CartController@add')->name('add-cart');
Route::get('/decrementar-carrinho/{product}', 'CartController@decrement')->name('decrement-cart');

Auth::routes();

Route::get('return-paypal', 'PayPalController@returnPayPal')->name('return.paypal');

Route::group(['middleware' => 'cart.items'], function() {
    Route::get('paypal', 'PayPalController@paypal')->name('paypal');
});



