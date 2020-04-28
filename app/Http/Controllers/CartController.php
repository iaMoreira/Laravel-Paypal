<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart');
        $cart->getItems(); 
        return view('cart.index');
    }

    public function add(Request $request, Product $product)
    {
        $cart = new Cart();
        $cart->add($product);

        $request->session()->put('cart', $cart);

        return redirect()->route('cart');
    }
}
