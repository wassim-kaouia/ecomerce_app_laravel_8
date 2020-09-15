<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('products.index');
});



/* Products Routes */
Route::get('/boutique' , 'App\Http\Controllers\ProductController@index')->name('products.index');
Route::get('/boutique/{slug}','App\Http\Controllers\ProductController@show')->name('products.show');


/* Cart Routes */
Route::post('/panier/ajouter','App\Http\Controllers\CartController@store')->name('cart.store');