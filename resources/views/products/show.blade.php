@extends('layout.layout')


@section('content')
  

<div class="row mb-2">

    

  <div class="col-md-12">
    <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
      <div class="col p-4 d-flex flex-column position-static">
        <strong class="d-inline-block mb-2 text-primary">{{ Str::substr($product->title, 0, 20).'...'  }}</strong>
        <div class="mb-1 text-muted">{{ $product->created_at->format('d/m/Y') }}</div>
        <p class="card-text mb-auto">{{ Str::substr($product->description, 0, 70).' ...' }}</p>
        <strong>{{ $product->getPrice() }}</strong>
        <form action="{{ route('cart.store') }}" method="POST">
            @csrf

            <input type="hidden" name="id"  value="{{ $product->id }}" />
            <input type="hidden" name="title" value="{{ $product->title }}" />
            <input type="hidden" name="price" value="{{ $product->price }}" />

            <button type="submit" class="bt btn-dark">Ajouter Au Panier</button>
        </form>
      </div>
      <div class="col-auto d-none d-lg-block">
          <img src="{{ $product->image }}" alt="">
      </div>
    </div>
  </div>


  </div>
</div>

    
@endsection