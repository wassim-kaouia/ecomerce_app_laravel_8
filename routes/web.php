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


Route::get('/vider',function(){
    Cart::destroy();
});