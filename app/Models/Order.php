<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'total', 'status', 'payment_id', 'identity'];


    public function products()
    {
        return $this->belongsToMany(Product::class, OrderProduct::class);
    }
}
