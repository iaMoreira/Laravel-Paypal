@extends('layout.master')


@section('content')
    <h1>Lançamentos recentes</h1>
    <div class="row">
        @foreach ($products as $product)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card">
                <img src="{{asset($product->image)}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">{{$product->name}}</h5>
                  <p class="card-text">{{$product->description}}</p>
                  <a href="{{route('add-cart', $product->id)}}" class="btn btn-primary">
                    Adicionar ao carrinho
                    <i class="fa fa-shopping-cart"></i>
                  </a>
                </div>
              </div>
        </div>
        @endforeach

    </div>
@endsection
