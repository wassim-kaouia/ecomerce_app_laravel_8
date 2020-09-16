<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cart.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->product_id);
        //this is part of shopingcart package - class of the package
       

        $duplicata = Cart::search(function ($cartItem, $rowId) use($request){
            return $cartItem->id == $request->product_id;
        });
         
        if($duplicata->isNotEmpty()){
            return redirect()->route('products.index')->with('success','le produit a été dèja ajouté !');
        }
        

        $product   = Product::findOrFail($request->product_id);
        Cart::add($product->id,$product->title,1,$product->price)->associate(Product::class);

        return redirect()->route('products.index')->with('success','le produit a été bien ajouté !');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowid)
    {
        Cart::remove($rowid);

        return back()->with('success','le produit a été bien supprimé !');
    }
}
