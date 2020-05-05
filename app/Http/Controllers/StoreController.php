<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('home.index', compact('products'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', auth()->user()->id)->get();
        return view('orders.index', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        $products = $order->products()->get();

        

        return view('orders.items', compact('order', 'products'));
    }
}
