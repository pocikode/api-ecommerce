<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Transformers\CartItemTransformer;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.customer');
    }

    # show cart
    public function show(Request $req, CartItemTransformer $transform)
    {
        # check cart
        $cart = Cart::where('customer_id', $req->user->customer_id)->first();
        if (!$cart) {
            $cart = Cart::create([
                'customer_id'   => $req->user->customer_id,
            ]);
        }

        return response()->json($transform->transform($cart));
    }

    # add to cart
    public function addToCart(Request $req)
    {
        # validate data
        $this->validate($req, [
            'product_id' => 'required|integer',
            'size'       => 'required'
        ]);

        # get cart data
        $cart = Cart::where('customer_id', $req->user->customer_id)->first();
        if (!$cart) {
            # if cart data is not exitst, create one
            $cart = Cart::create([
                'customer_id' => $req->user->customer_id,
            ]);
        }

        $product = Product::find($req->product_id);
        if (!$product) return false;

        # update cart data
        $cart->update([
            'total' => $cart->total += $product->price,
            'total_qty' => $cart->total_qty += 1
        ]);

        # crate cart item
        $item = CartItem::create([
            'cart_id'      => $cart->cart_id,
            'product_id'   => $product->product_id,
            'product_name' => $product->name,
            'size'         => $req->size,
            'price'        => $product->price
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'data'    => $item
        ]);
    }

    # delete item
    public function delete(Request $req, $idItem)
    {
        # check item
        $item = CartItem::find($idItem);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item Not Found!'
            ], 404);
        }

        $cart = Cart::where('cart_id', $item->cart_id)->first();
        if ($cart->customer_id != $req->user->customer_id) {
            return response()->json([
                'success' => false,
                'message' => 'The item is not in your cart! You cannot delete it!'
            ], 400);
        }

        # update cart
        $cart->update([
            'total' => $cart->total -= $item->price,
            'total_qty' => $cart->total_qty -= 1,
        ]);

        $item->delete();
        return response()->json([
            'success' => true,
            'message' => 'Item deleted!'
        ]);
    }
}