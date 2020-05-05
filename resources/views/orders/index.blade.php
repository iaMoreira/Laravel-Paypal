@extends('layout.master')

@section('content')
    <h1 class="title"> Meus Pedidos:</h1>
    <table class="table table-striped">
        <tr>
            <th>Número</th>
            <th>Total</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->total}}</td>
                    <td>{{$order->status}}</td>
                    <td>
                        <a href="{{route('order.products', $order->id)}}" class="btn btn-primary"> Ver Produtos</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="20"> Nenhum pedido realizado</td>
                </tr>
            @endforelse

        </tbody>
    </table>
@endsection
