<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_items';

    protected $fillable = [
        'cart_id', 'product_id', 'product_name', 'size', 'price'
    ];

    public function cart()
    {
        return $this->belongsTo('App\Cart');
    }
}