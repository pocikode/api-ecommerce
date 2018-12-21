<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Resources\OrderResources;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.admin');
    }

    # show orders data where status is unconfirmed have payment and payment is unconfirmed only
    public function unconfirmed()
    {
        $unconfirmedOrders = OrderResources::unconfirmed();

        return array_merge(['total' => count($unconfirmedOrders['data'])], $unconfirmedOrders);
    }

    # confirm order
    public function confirm(Request $req)
    {
        $this->validate($req, [
            'order_id' => 'required|integer',
        ]);

        $order = Order::find($req->get('order_id'));
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order Not Found'
            ], 404);
        }
        
        # update order status
        $order->update(['status' => 'confirmed']);

        # update payment status
        $order->payment()->update(['status' => 'confirmed']);

        return response()->json([
            'success'   => true,
            'message'   => 'Order Confirmed successfull'
        ]);
    }

    # show processed orders
    public function processed()
    {
        $orders = OrderResources::get('confirmed');

        return array_merge(['total' => count($orders['data'])], $orders);
    }

    # confirm shipping order
    public function confirmShipping(Request $req)
    {
        $this->validate($req, [
            'order_id'  => 'required|integer',
            'awb'       => 'required|string',
        ]);

        $order = Order::find($req->order_id);
        if (!$order) {
            return response()->json([
                'success'   => false,
                'message'   => 'Order Not Found!',
            ], 404);
        }

        $order->update([
            'awb'   => $req->awb,
            'status'=> 'shipped',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Success'
        ]);
    }

    # show success orders
    public function success()
    {
        $orders = OrderResources::get('success');

        return array_merge(['total' => count($orders['data'])], $orders);
    }
}