<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipping;

class ShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.customer');
    }

    # show shippings
    public function index(Request $req)
    {
        $shippings = Shipping::where('customer_id', $req->user->customer_id)->get();

        return response()->json([
            'success'       => true,
            'customer_id'   => $req->user->customer_id,
            'customer_name' => $req->user->name,
            'data_total'    => $shippings->count(),
            'shippings'     => $shippings,
        ]);
    }

    # show shipping info
    public function show(Request $req, $id)
    {
        # check shipping
        $shipping = Shipping::find($id);
        if (!$shipping) {
            return response()->json([
                'success' => false,
                'message' => 'Shipping Not Found!',
            ], 404);
        } elseif ($shipping->customer_id != $req->user->customer_id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot change the data!',
            ], 400);
        }

        return response()->json([
            'success'       => true,
            'customer_id'   => $req->user->customer_id,
            'customer_name' => $req->user->name,
            'shipping'      => $shipping,
        ]);
    }

    # create shipping
    public function create(Request $req)
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

        # insert to database
        $shipping = Shipping::create([
            'customer_id'   => $req->user->customer_id,
            'received_name' => $req->received_name,
            'address'       => $req->address,
            'province_id'   => $req->province_id,
            'city_id'       => $req->city_id,
            'zip'           => $req->zip,
            'phone'         => $req->phone,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Add Shipping Successfull',
            'data'    => $shipping,
        ]);
    }

    # update shipping
    public function update(Request $req, $id)
    {
        # check shipping
        $shipping = Shipping::find($id);
        if (!$shipping) {
            return response()->json([
                'success' => false,
                'message' => 'Shipping Not Found!',
            ], 404);
        } elseif ($shipping->customer_id != $req->user->customer_id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot change the data!',
            ], 400);
        }

        # validate form data
        $this->validate($req, [
            'received_name' => 'required|string',
            'address'       => 'required|string',
            'province_id'   => 'required|integer',
            'city_id'       => 'required|integer',
            'zip'           => 'required|integer',
            'phone'         => 'required|numeric',
        ]);

        # update
        $shipping->update($req->all());

        return response()->json([
            'success' => true,
            'message' => 'Shipping updated!'
        ]);
    }

    # delete shipping
    public function delete(Request $req, $id)
    {
        # check shipping
        $shipping = Shipping::find($id);
        if (!$shipping) {
            return response()->json([
                'success' => false,
                'message' => 'Shipping Not Found!',
            ], 404);
        } elseif ($shipping->customer_id != $req->user->customer_id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete the data!',
            ], 400);
        }

        # delete
        $shipping->delete();

        return response()->json([
            'success' => true,
            'message' => 'Shipping deleted!'
        ]);
    }
}