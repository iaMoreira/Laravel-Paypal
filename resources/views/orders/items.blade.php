@extends('layout.master')

@section('content')
    <h1 class="title"> Detalhes do pedido:  {{$order->id}}</h1>
    <table class="table table-striped">
        <tr>
            <th>Foto</th>
            <th>Nome</th>
            <th>Quantidade</th>
            <th>Preço</th>
        </tr>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>
                        <img src="{{asset($product->image)}}" width="100px">
                    </td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->pivot->qtd}}</td>
                    <td>{{$product->pivot->price}}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="20"> Nenhum pedido realizado</td>
                </tr>
            @endforelse

        </tbody>
    </table>
@endsection
