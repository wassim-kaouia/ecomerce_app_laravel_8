<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{

    public function index()
    {

        //si le panier est vide on interdit le client d'aller vers paiment
        if(Cart::count() <= 0){
            return redirect()->route('products.index');
        }

        Stripe::setApiKey('sk_test_UjgB7XsExaDQ2QtwUIA5WbpT00ZOjl3nOe');

        $intent = \Stripe\PaymentIntent::create([
            'amount' => round(Cart::total()),
            'currency' => 'usd',
            'payment_method_types' => ['card'],
          ]);

        //   dd($intent);

        //on aura besoin de la cle secret pour l'injecter dans notre front end
        $clientSecret = Arr::get($intent,'client_secret');
        // dd($clientSecret);
        return view('checkout.index',['clientSecret' => $clientSecret]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        Cart::destroy();

        $data = $request->json()->all();

        return $data['paymentIntent'];
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
