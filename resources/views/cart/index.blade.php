@extends('layout.master')

@section('content')

    <h1>Meu Carrinho de compras</h1>


    <table class="w-100 table table-bordered table-striped table-responsive">
        <thead>
            <th class="w-50">Item</th>
            <th style="width: 15%; text-align: center;">Preço</th>
            <th style="width: 20%; text-align: center;">Qtd.</th>
            <th style="width: 15%; text-align: center;">Sub. Total</th>
        </thead>

        <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>
                        <div class="d-flex ">
                            <img class="img-thumbnail w-25 mr-3" src="{{asset($item['item']->image)}}" alt="">
                            <div>
                                <h5 class="font-weight-bold ">{{$item['item']->name}}</h5>
                                <p class="font-italic text-muted">
                                    {{$item['item']->description}}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="text-center"> R$ {{$item['item']->price}}</td>
                    <td class="text-center">
                        <a href="{{route('decrement-cart', $item['item']->id)}}" class="btn btn-danger btn-sm"> - </a>
                        {{$item['qtd']}}
                        <a href="{{route('add-cart', $item['item']->id)}}" class="btn btn-success btn-sm"> + </a>
                    </td>
                    <td class="text-center">R$ {{ $item['item']->price * $item['qtd'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="20"> Carrinho Vazio</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex flex-column">
        <div class=" bg-light p-3">
            <h3 class="text-right">
                <b>Total: </b> R$ {{$total}}
            </h3>
        </div>

        <div class="float-right">
            <a class="btn btn-success text-white float-right"
                href="{{route('paypal')}}"> Finalizar compra</a>
        </div>

    </div>
@endsection
