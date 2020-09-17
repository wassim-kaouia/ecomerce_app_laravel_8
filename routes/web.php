<?php

use Illuminate\Support\Facades\Route;
use Gloudemans\Shoppingcart\Facades\Cart;



Route::get('/', function () {
    return view('products.index');
});



/* Products Routes */
Route::get('/boutique' , 'App\Http\Controllers\ProductController@index')->name('products.index');
Route::get('/boutique/{slug}','App\Http\Controllers\ProductController@show')->name('products.show');


/* Cart Routes */
Route::get('panier','App\Http\Controllers\CartController@index')->name('cart.index');
Route::post('/panier/ajouter','App\Http\Controllers\CartController@store')->name('cart.store');
Route::delete('/panier/{rowid}','App\Http\Controllers\CartController@destroy')->name('cart.destroy');

/* Checkout Routes */
Route::get('paiment','App\Http\Controllers\CheckoutController@index')->name('checkout.index');
Route::post('paiment','App\Http\Controllers\CheckoutController@store')->name('checkout.store');
Route::get('/merci',function(){
    return view('checkout.thanks');
});



Route::get('/vider',function(){
    Cart::destroy();
});