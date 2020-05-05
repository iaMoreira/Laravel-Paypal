<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PayPal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PayPalController extends Controller
{

    public function paypal(Order $order)
    {
        $paypal = new PayPal();

        $result = $paypal->generate();

        if($result['status']){
            $paymentId = $result['payment_id'];
            $order->newOrdeProducts($result['totalCart'], $result['payment_id'], $result['identity'], $result['itemsCart']);

            Session::put('payment_id', $paymentId);

            return redirect()->away($result['url_paypal']);
        }
        return redirect()->route('cart')->with('message', 'Erro inesperado');
    }
    public function returnPayPal(Request $request, Order $order, Cart $cart)
    {
        $success = $request->success;
        $paymentId = $request->paymentId;
        $token = $request->token;
        $payerID = $request->PayerID;

        if(!$success){
            return redirect()->route('cart')->with('message', 'Pedido Cancelado!');
        }

        if(empty($paymentId) || empty($token) || empty($payerId)){
            return redirect()->route('cart')->with('message', 'Não autorizado!');
        }

        if(!Session::has('payment_id') || Session::get('payment_id') != $paymentId){
            return redirect()->route('cart')->with('message', 'Não autorizado!');
        }


        $paypal = new PayPal();
        $response =  $paypal->execute($paymentId, $token, $payerID);

        if($response == 'approved'){
            $order->changeStatus($paymentId, 'approved');
            
            $cart->emptyItems();
            Session::forget('payment_id');

            return redirect()->route('home');
        }else {
            return redirect()->route('cart')->with('message', 'Pedido não aprovado!');
        }

    }
}
