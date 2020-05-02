<?php

namespace App\Http\Controllers;

use App\Models\PayPal;
use Illuminate\Http\Request;

class PayPalController extends Controller
{

    public function paypal()
    {
        // $cart = new Cart();

        $paypal = new PayPal();

        return redirect()->away($paypal->generate());
    }
    public function returnPayPal(Request $request)
    {
        dd($request->all());
    }
}
