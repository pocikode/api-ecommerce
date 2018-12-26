<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Resources\ShippingResource;
use DB;

class ShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.customer');
    }

    # show shipping info
    public function show(Request $req)
    {
        # check shipping
        $shipping = ShippingResource::get($req->user->customer_id);


        return response()->json([
            'success'       => true,
            'customer_id'   => $req->user->customer_id,
            'customer_name' => $req->user->name,
            'shipping'      => $shipping,
        ]);
    }

    # create shipping
    public function post(Request $req)
    {
        # validate form data
        $this->validate($req, [
            'received_name' => 'required|string',
            'address'       => 'required|string',
            'province_id'   => 'required|integer',
            'city_id'       => 'required|integer',
            'zip'           => 'required|integer',
            'phone'         => 'required|numeric',
        ]);

        # check data shippings
        $shipping = Shipping::where('customer_id', $req->user->customer_id)->first();
        if (!$shipping) {
            # insert to database
            $shipping = Shipping::create(array_merge(['customer_id' => $req->user->customer_id], $req->all()));

            return response()->json([
                'success' => true,
                'message' => 'Add Shipping Successfull',
                'data' => $shipping,
            ]);
        } else {
            # update
            $shipping->update($req->all());

            return response()->json([
                'success' => true,
                'message' => 'Shipping Updated',
            ]);
        }
    }
}