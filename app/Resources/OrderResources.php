<?php

namespace App\Resources;

use App\Models\Order;
use App\Transformers\OrderTransformer;
use League\Fractal;

class OrderResources
{
    # get customer unpaid orders
    public static function unpaid($customerID)
    {
        $fractal = new Fractal\Manager;

        $orders = Order::where('customer_id', $customerID)->where('status', 'unconfirmed')->get();

        # sort for order have no payment only
        foreach ($orders as $key => $order) {
            if ($order->payment()->first())
                unset($orders[$key]);
        }

        $data = $fractal->createData(new Fractal\Resource\Collection($orders, new OrderTransformer));
        return $data->toArray();
    }

    # get unconfirmed orders and have payment
    public static function unconfirmed($customerID = null)
    {
        $fractal = new Fractal\Manager;

        if (is_null($customerID)) {
            $orders = Order::where('status', 'unconfirmed')->get();
        } else {
            $orders = Order::where('customer_id', $customerID)->where('status', 'unconfirmed')->get();
        }

        # sort for orders data where status is unconfirmed and have payment and payment is unconfrmed only
        foreach ($orders as $key => $order) {
            if (!$order->payment()->first() || $order->payment()->first()->status == 'confirmed') {
                unset($orders[$key]);
            }
        }

        $data = $fractal->createData(new Fractal\Resource\Collection($orders, new OrderTransformer));
        return $data->toArray();
    }

    # get by status and customer id
    public static function get($status = null, $customerID = null)
    {
        $fractal = new Fractal\Manager;

        if (is_null($customerID) && !is_null($status)) {
            $orders = Order::where('status', $status)->get();
        } else if (!is_null($customerID) && !is_null($status)) {
            $orders = Order::where('customer_id', $customerID)->where('status', $status)->get();
        } else {
            return false;
        }

        $resource = new Fractal\Resource\Collection($orders, new OrderTransformer);
        return $fractal->createData($resource)->toArray();
    }
}