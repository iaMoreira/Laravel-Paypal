<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Closure;
use Illuminate\Support\Facades\Session;

class CartItemsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Session::has('cart')){
            return redirect()->route('home');
        }

        $cart = new Cart();

        if($cart->totalItems() == 0){
            return redirect()->route('home');
        }

        return $next($request);
    }
}
