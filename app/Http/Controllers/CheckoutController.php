<?php

namespace App\Http\Controllers;

use DateTime;
use Stripe\Stripe;
use App\Models\Order;
use Stripe\PaymentIntent;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
        

        $data = $request->json()->all();

        $order = new Order();

        $order->payment_intent_id = $data['paymentIntent']['id'];
        $order->amount = $data['paymentIntent']['amount'];
        $order->payment_created_at = (new DateTime())
                                        ->setTimestamp($data['paymentIntent']['created'])
                                        ->format('Y-m-d H:i:s');

        $products = [];
        $i = 0;

        foreach(Cart::content() as $product){
            $products['product_' . $i][] = $product->model->title;
            $products['product_' . $i][] = $product->model->price;
            $products['product_' . $i][] = $product->qty;
            $i++;
        }

        $order->products = \serialize($products);
        $order->user_id = 15;
        $order->save();

        if($data['paymentIntent']['status'] == 'succeeded'){
            Cart::destroy();
            Session::flash('success','votre commande a été traitée avec succés');
            return \response()->json(['sccess' => 'Payment Intent Succeeded']);
        }else{
            return \response()->json(['error' => 'Payment Intent Not Succeeded']);
        }



    }

    public function thankYou(){
        return Session::has('success') ? view('checkout.thanks') : redirect()->route('products.index');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $rowId)
    {
        
    }


    public function destroy($id)
    {
        //
    }
}
