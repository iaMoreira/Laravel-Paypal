<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'total', 'status', 'payment_id', 'identity'];


    public function products()
    {
        return $this->belongsToMany(Product::class, OrderProduct::class)->withPivot('qtd', 'price');
    }

    public function  newOrdeProducts($totalCart, $paymentId, $identity, $itemsCart)
    {
        $order = $this->create([
            'user_id'   => auth()->user()->id,
            'total'     => $totalCart,
            'status'    => 'started',
            'payment_id'=> $paymentId,
            'identity'  => $identity,
        ]);

        $productsOrder = [];
        foreach($itemsCart as $item){
            $productsOrder[$item['item']->id] = [
                'qtd'   => $item['qtd'],
                'price' => $item['item']->price
            ];
        }
        $order->products()->attach($productsOrder);
    }

    public function changeStatus($paymentId, $status)
    {
        $this->where('payment_id', $paymentId)
            ->update(['status' => $status]);

    }
}
