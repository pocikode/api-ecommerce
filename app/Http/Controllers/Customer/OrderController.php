<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Resources\OrderResources;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(Request $req)
    {
        $this->middleware('jwt.customer');
        $this->request = $req;
    }

    # show un paid orders
    public function unpaid()
    {
        $orders = OrderResources::get('unpaid', $this->request->user->customer_id); # get unpaid orders

        $credentials = [
            'success'       => true,
            'customer_id'   => $this->request->user->customer_id,
            'customer_name' => $this->request->user->name,
            'total'         => count($orders['data']),
        ];

        return array_merge($credentials, $orders);
    }

    # show waiting confirm orders
    public function waitingConfirm()
    {
        $orders = OrderResources::unconfirmed($this->request->user->customer_id);

        $credentials = [
            'success'       => true,
            'customer_id'   => $this->request->user->customer_id,
            'customer_name' => $this->request->user->name,
            'total'         => count($orders['data']),
        ];

        return array_merge($credentials, $orders);
    }

    # show on process orders
    public function onProcess()
    {
        $orders = OrderResources::get('confirmed', $this->request->user->customer_id);

        $credentials = [
            'success' => true,
            'customer_id' => $this->request->user->customer_id,
            'customer_name' => $this->request->user->name,
            'total' => count($orders['data']),
        ];

        return array_merge($credentials, $orders);
    }

    # show on shipping orders
    public function onShipping()
    {
        $orders = OrderResources::get('shipped', $this->request->user->customer_id);

        $credentials = [
            'success' => true,
            'customer_id' => $this->request->user->customer_id,
            'customer_name' => $this->request->user->name,
            'total' => count($orders['data']),
        ];

        return array_merge($credentials, $orders);
    }

    # confirm received order
    public function received(Request $req)
    {
        $this->validate($req, [
            'order_id' => 'required|integer'
        ]);

        $order = Order::find($req->order_id);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order Not FOund!'
            ], 404);
        }

        $order->update(['status' => 'success']);
        return response()->json([
            'success' => true,
            'message' => 'Success'
        ]);
    }

    # show order history
    public function history()
    {
        $orders = OrderResources::get('success', $this->request->user->customer_id);

        $credentials = [
            'success' => true,
            'customer_id' => $this->request->user->customer_id,
            'customer_name' => $this->request->user->name,
            'total' => count($orders['data']),
        ];

        return array_merge($credentials, $orders);
    }
}