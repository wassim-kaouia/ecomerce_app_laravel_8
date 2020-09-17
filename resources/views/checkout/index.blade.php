@extends('layout.layout')

@section('extra-script')
    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('extra-meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <h2>Page de Paiement:</h2>

    <div class="row mt-4">
        <div class="col-md-6">
            <form id="payment-form" action="{{ route('checkout.store') }}" method="POST">
              @csrf
                <div id="card-element">
                  <!-- Elements will create input elements here -->
                </div>
              
                <!-- We'll put the error messages in this element -->
                <div id="card-errors" role="alert"></div>
                <button class="mt-4 btn btn-danger" id="submit">Proceder au Paiement ({{ getPrice(Cart::total()) }})</button>
              </form>
        </div>
    </div>
@endsection


@section('extra-js')
    <script>
          /*initialisation de stripe avec la clé*/
          var stripe = Stripe('pk_test_LgP44d7FyF6kMsFKAhQsmnO7');
          var elements = stripe.elements();
          //le style du form
          var style = {
           base: {
            color: "#32325d",
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "16px",
              "::placeholder": {
                 color: "#aab7c4"
            }
           },
          invalid: {
          color: "#fa755a",
          iconColor: "#fa755a"
    }
  };
        // monter les elements du form
        var card = elements.create("card", { style: style });
        card.mount("#card-element");
        //afficher et gerer les errors du form
        card.on('change', ({error}) => {
        const displayError = document.getElementById('card-errors');
       if (error) {
         displayError.classList.add('alert','alert-warning');  
         displayError.textContent = error.message;
       } else {
        displayError.classList.remove('alert','alert-warning'); 
        displayError.textContent = '';
  }
  
});
    //submission du form 
    var form = document.getElementById('payment-form');

   form.addEventListener('submit', function(ev) {
   ev.preventDefault();
   form.disabled = true;
   stripe.confirmCardPayment("{{ $clientSecret }}", {
    payment_method: {
      card: card,
    }
  }).then(function(result) {
    if (result.error) {
      form.disabled = false;
      // Show error to your customer (e.g., insufficient funds)
      console.log(result.error.message);
    } else {
      // The payment has been processed!
      if (result.paymentIntent.status === 'succeeded') {
          var paymentIntent = result.paymentIntent;
          var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
          var form = document.getElementById('payment-form');
          var url = form.action;
          var redirect = '/merci';

          fetch(
            url,
            {
                headers: {
                  "Content-Type": "application/json",
                  "Accept": "application/json, text-plain, */*",
                  "X-Requested-With": "XMLHttpRequest",
                  "X-CSRF-TOKEN": token
                },
                method: 'post',
                body: JSON.stringify({
                  //je dois envoyer ça vers store action dans mon controller de checkout afin de stockers les info sur DB
                  paymentIntent: paymentIntent,

                })
            }
          ).then((data) => {
             console.log()
             window.location.href = redirect;
          }).catch((error) => {
             console.log(error)
          })
        // console.log(result.paymentIntent);
      }
    }
  });
});


    </script>
@endsection