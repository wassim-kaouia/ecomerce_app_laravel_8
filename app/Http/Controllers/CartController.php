<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    public function index()
    {
        return view('cart.index');
    }


    public function create()
    {
        //
    }


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

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        
    }


    public function update(Request $request, $rowId)
    {
        $data = $request->json()->all();

        $validator = Validator::make($request->all(),[
            'qty' => 'required|numeric|between:1,6'
        ]);
        
        if($validator->fails()){
            Session::flash('danger','la quantité ne peux pas depasser 6');
            return response()->json(['error' => 'Cart qty has NOT been updated']); 
        }
        // dd($data);
        Cart::update($rowId,$data['qty']);

        Session::flash('success','la quantitée est mise à jours à '.$data['qty']);

        return response()->json(['success' => 'Cart qty has been updated']);
    }

    public function destroy($rowId)
    {
        Cart::remove($rowId);

        return back()->with('success','le produit a été bien supprimé !');
    }
}
