<?php

namespace App\Transformers;

use League\Fractal;
use League\Fractal\TransformerAbstract;
use App\Models\Cart;

class CartItemTransformer extends TransformerAbstract
{
    public function transform(Cart $cart)
    {
        return [
            'cart_id'       => (int) $cart->cart_id,
            'customer_id'   => (int) $cart->customer_id,
            'total'         => $cart->total,
            'total_qty'     => $cart->total_qty,
            'items'         => $cart->cartItem()->get(),
        ];
    }
}