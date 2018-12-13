<?php

namespace App\Transformers;

use League\Fractal;
use League\Fractal\TransformerAbstract;
use App\Models\Cart;

class CartItemTransformer extends TransformerAbstract
{
    public static function transform(Cart $cart)
    {
        return [
            'customer_id'   => (int) $cart->customer_id,
            'customer_name' => $cart->customer()->first()->name,
            'cart_id'       => (int) $cart->cart_id,
            'qty'           => $cart->total_qty,
            'amount'        => $cart->total,
            'shipping_cost' => false,
            'total'         => false,    
            'items'         => $cart->cartItem()->get(),
        ];
    }
}