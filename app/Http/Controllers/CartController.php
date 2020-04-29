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
        $items = $cart->getItems();
        // dd($items);
        return view('cart.index', compact('items'));
    }

    public function add(Product $product)
    {
        $cart = new Cart();
        $cart->add($product);

        Session::put('cart', $cart);

        return redirect()->route('cart');
    }

    public function decrement(Product $product){
        $cart = new Cart();
        $cart->decrement($product);

        Session::put('cart', $cart);
        return redirect()->route('cart');
    }
}
