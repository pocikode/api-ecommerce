<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Resources\PaymentResource;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.admin', ['only' => ['unconfirmed']]);
    }

    # show payment info
    public function show($id)
    {
        $payment = PaymentResource::show($id);
        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found!',
            ], 404);
        }

        return response()->json($payment);
    }

    public function unconfirmed()
    {
        $unconfirmedPayment = PaymentResource::unconfirmed();
        return response()->json(array_merge(['total' => count($unconfirmedPayment['data'])], $unconfirmedPayment));
    }
}