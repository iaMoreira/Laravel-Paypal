@extends('layout.master')

@section('content')

    <h1>Meu Carrinho de compras</h1>


    <table class="w-100 table table-bordered table-striped table-responsive">
        <thead>
            <th>Item</th>
            <th>Preço</th>
            <th>Qtd.</th>
            <th>Sub. Total</th>
        </thead>

        <tbody>
            <tr>
                <td>
                    <div class="d-flex ">
                        <img class="img-thumbnail w-25 mr-3" src="{{asset('images/img1.jpg')}}" alt="">
                        <h6 class="font-weight-bold ">Nome do produto</h6>
                    </div>
                </td>
                <td> R$ 30,00</td>
                <td>
                    <a >-</a>
                     2
                     <a >+ </a>
                </td>
                <td>R$ 60,00</td>
            </tr>
        </tbody>
    </table>

    <div class="d-flex flex-column">
        <div class=" bg-light p-3">
            <h3 class="text-right">
                <b>Total: </b> R$ 500,00
            </h3>
        </div>

        <div class="float-right">
            <a class="btn btn-success text-white float-right"> Finalizar compra</a>
        </div>

    </div>
@endsection
