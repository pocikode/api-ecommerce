<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CountController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.admin');
    }

    public function count()
    {
        $customers  = \App\Models\Customer::all()->count();
        $products   = \App\Models\Product::all()->count();
        $unconfirmed= \App\Models\Order::where('status', 'unconfirmed')->count(); # unconfirmed order
        $success    = \App\Models\Order::where('status', 'success')->count(); # successed order

        return response()->json([
            'customers'         => $customers,
            'products'          => $products,
            'unconfirmed_orders'=> $unconfirmed,
            'success_order'     => $success,
        ]);
    }
}