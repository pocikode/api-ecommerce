<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey = 'cart_id';

    protected $fillable = ['product_id', 'customer_id', ];

    public function cartItem()
    {
        return $this->hasMany('App\Models\CartItem', 'cart_id');
    }
}