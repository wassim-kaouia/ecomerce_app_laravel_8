<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){

        $products  = Product::inRandomOrder()->take(6)->get();

        // dd($products);
        
        return view('products.index')->with(['products' => $products]);

    }



    public function show($id){
        // $product = Product::where('slug','$slug')->first();
        $product = Product::findOrFail($id);
        // dd($product);
        return view('products.show',['product' => $product]);

    }
}
