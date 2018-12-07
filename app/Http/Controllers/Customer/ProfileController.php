<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.customer');
    }

    public function show(Request $req)
    {
        $customer = Customer::find($req->user->customer_id);
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Bad Request'
            ], 400);
        }

        return response()->json($customer);
    }

    public function update(Request $req)
    {
        $customer = Customer::find($req->user->customer_id);
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Bad Request'
            ], 400);
        }

        $customer->update($req->all());
        return response()->json([
            'success' => true,
            'message' => 'Profile updated!'
        ]);
    }
}