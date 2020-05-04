<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PayPal;
use Illuminate\Http\Request;

class PayPalController extends Controller
{

    public function paypal(Order $order)
    {
        $paypal = new PayPal();

        $result = $paypal->generate();

        if($result['status']){
            $order->newOrdeProducts($result['totalCart'], $result['payment_id'], $result['identity'], $result['itemsCart']);
            return redirect()->away($result['url_paypal']);
        }
        return redirect()->route('cart')->with('message', 'Erro inesperado');
    }
    public function returnPayPal(Request $request, Order $order)
    {
        $success = $request->success;
        $paymentId = $request->paymentId;
        $token = $request->token;
        $payerID = $request->PayerID;
        if(!$success){
            dd($request->all()) ;
        }

        $paypal = new PayPal();
        $response =  $paypal->execute($paymentId, $token, $payerID);

        if($response == 'approved'){
            $order->where('payment_id', $paymentId)->update(['status' => 'approved']);
            return redirect()->route('home');
        }else {
            dd('Pedido não aprovado.');
        }

    }
}
