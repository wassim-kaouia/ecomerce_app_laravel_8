@extends('layout.layout')


@section('content')
    
<div class="row mb-2">

    
  @forelse ($products as $product)
  <div class="col-md-6">
    <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
      <div class="col p-4 d-flex flex-column position-static">
        <strong class="d-inline-block mb-2 text-primary">{{ Str::substr($product->title, 0, 20).'...'  }}</strong>
        <div class="mb-1 text-muted">{{ $product->created_at->format('d/m/Y') }}</div>
        <p class="card-text mb-auto">{{ Str::substr($product->description, 0, 70).' ...' }}</p>
        <strong>{{ $product->getPrice() }}</strong>
        <a href="{{ route('products.show', ['slug' => $product->slug] ) }}" class="stretched-link btn btn-info">voir l'article</a>
      </div>
      <div class="col-auto d-none d-lg-block">
          <img src="{{ $product->image }}" alt="">
      </div>
    </div>
  </div>
  @empty
      
  @endforelse

  </div>

@endsection