<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        # set user level
        $this->middleware('jwt.customer');
    }
    # confirm payment for custoemer
    public function confirmCustomer(Request $req)
    {
        # form data validation
        $this->validate($req, [
            'invoice'       => 'string|required',
            'to_bank'       => 'integer|required',
            'bank_name'     => 'string|required',
            'account_name'  => 'string|required',
            'account_number'=> 'integer|required',
            'amount'        => 'integer|required',
            'date'          => 'date|required',
        ]);

        $order = Order::where('invoice', $req->invoice)->where('customer_id', $req->user->customer_id)->first(); // order data

        # if no order data
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'No order data with this invoice'
            ], 406);
        }

        # if due date expired
        if (date('Y-m-d H:i:s') >= $order->due_date) {
            return response()->json([
                'success' => false,
                'message' => 'Due date is expired!',
                'info'    => [
                    'invoice'   => $order->invoice,
                    'due_date'  => $order->due_date,
                ],
            ], 417);
        }

        # if customer already confirm payment
        $checkPayment = Payment::where('invoice', $req->invoice)->first();
        if ($checkPayment) {
            return response()->json([
                'success'   => false,
                'message'   => 'You have already confirm this order!',
                'info'      => $checkPayment,
            ], 400);
        }

        $data = $req->all();
        $data['customer_id'] = $req->user->customer_id;
        $data['order_id'] = $order->order_id;
        $data['to_bank']  = \App\Models\Bank::find($req->to_bank)->bank_name;

        $payment = Payment::create($data);
        return response()->json([
            'success'   => true,
            'data'      => $payment,
        ]);
    }
}