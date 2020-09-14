<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('products.index');
});



/* Products Routes */
Route::get('/boutique' , 'App\Http\Controllers\ProductController@index');
Route::get('/boutique/{id}','App\Http\Controllers\ProductController@show')->name('products.show');