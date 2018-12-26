<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Resources\ShippingResource;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Resources\CartResource;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.customer');
    }

    # Checkout
    public function checkout(Request $req)
    {
        # get data cart
        $data = CartResource::get($req->user->customer_id);
        if ($data['cart']['qty'] == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty!',
            ], 406);
        }

        # check shipping
        $shipping = ShippingResource::get($req->user->customer_id);
        if (!$shipping) {
            return response()->json([
                'success' => false,
                'message' => 'No shipping address',
                'shipping'=> null,
            ], 406);
        }

        # get shipping cost
        $shippingCost = \App\Resources\CourierResources::getShippingCost($shipping['city_id'], $data['cart']['total_weight']);

        $data['cart']['shipping_cost'] = $shippingCost['cost'];
        $data['cart']['total']         = $data['cart']['amount'] + $shippingCost['cost'];
        $data['shipping']              = $shipping;
        
        return response()->json(array_merge(['success' => true], $data));
    }

    # Proses checkout
    public function process(Request $req)
    {
        # get data cart
        $cart = CartResource::get($req->user->customer_id);
        if ($cart['cart']['qty'] == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty!',
            ], 406);
        }

        # check shipping
        $shipping = ShippingResource::get($req->user->customer_id);
        if (!$shipping) {
            return response()->json([
                'success' => false,
                'message' => 'No shipping address',
                'shipping' => null,
            ], 406);
        }

        # get shipping cost
        $shippingCost = \App\Resources\CourierResources::getShippingCost($shipping['city_id'], $cart['cart']['total_weight']);

        # generate invoice
        $invoice = $this->createInvoice();

        # insert to orders table
        $order = Order::create([
            'invoice'       => $invoice,
            'customer_id'   => $req->user->customer_id,
            'amount'        => $cart['cart']['amount'],
            'shipping_cost' => $shippingCost['cost'],
            'total_payment' => $cart['cart']['amount'] + $shippingCost['cost'],
            'received_name' => $shipping['received_name'],
            'address'       => $shipping['address'],
            'province_id'   => $shipping['province_id'],
            'city_id'       => $shipping['city_id'],
            'zip'           => $shipping['zip'],
            'phone'         => $shipping['phone'],
            'due_date'      => date('Y-m-d H:i:s', strtotime('+24 hours', strtotime(date('Y-m-d H:i:s')))),
        ]);

        $this->insertDetails($order->order_id, $cart['items']['data']); # insert to order details table
        $this->updateProducts($cart['items']['data']); # update product sizes
        $this->deleteCart($req->user->customer_id); # empty cart
        
        return response()->json($order);
    }

    # create invoice
    private function createInvoice()
    {
        # get max ID
        $maxID = Order::all()->max('order_id');
        $order = Order::find($maxID);
        if (!$order) {
            $invoiceNumber = sprintf("%04s", 1);
        } else {
            # get order date
            $orderDate = substr($order->created_at, 0, 10);

            # check date of order
            if (date('Y-m-d') != $orderDate) {
                $invoiceNumber = sprintf("%04s", 1);
            } else {
                $maxInvoice = (int)substr($order->invoice, 17, 4);
                $maxInvoice++;

                $invoiceNumber = sprintf("%04s", $maxInvoice);
            }
        }

        # create invoice
        $invoice = "ECM/" . date('Ymd') . "/INV/" . $invoiceNumber;
        return $invoice;
    }

    # insert into order details table
    private function insertDetails(int $orderID, $items)
    {
        foreach ($items as $item) {
            OrderDetail::create([
                'order_id'      => $orderID,
                'product_id'    => $item['product_id'],
                'product_name'  => $item['product_name'],
                'size'          => $item['size'],
                'price'         => $item['price'],
            ]);
        }
    }

    # update product data
    # decrease stock
    private function updateProducts($items)
    {
        foreach ($items as $item) {
            $product = Product::find($item['product_id']);

            # combine sizes and stocks
            $sizeStock = array_combine(json_decode($product->sizes), json_decode($product->stocks));
            $sizeStock[$item['size']]--;

            # if stock is empty, unset the size key
            if ($sizeStock[$item['size']] == 0)
                unset($sizeStock[$item['size']]);

            $product->update([
                'sizes' => json_encode(array_keys($sizeStock)),
                'stocks'=> json_encode(array_values($sizeStock)),
            ]);
        }
    }

    # delete cart & items
    private function deleteCart($customerID)
    {
        $cart = Cart::where('customer_id', $customerID)->first();
        $cart->delete();
    }
}