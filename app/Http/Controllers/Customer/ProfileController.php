<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Cloudinary\Uploader;
use App\Models\Order;

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

        return response()->json([
            'success' => true,
            'message' => '',
            'profile' => $customer,
            'orders'  => $this->orderStatus($req->user->customer_id)
        ]);
    }

    # order status
    private function orderStatus($customerID)
    {
        $unpaid = Order::where('customer_id', $customerID)->where('status', 'unpaid')->count();
        $unconfirmed = Order::where('customer_id', $customerID)->where('status', 'unconfirmed')->count();
        $confirmed = Order::where('customer_id', $customerID)->where('status', 'confirmed')->count();
        $shipped = Order::where('customer_id', $customerID)->where('status', 'shipped')->count();

        return [
            'waiting_payment' => $unpaid,
            'waiting_confirm' => $unconfirmed,
            'onprocess'       => $confirmed,
            'onshipping'      => $shipped
        ];
    }

    public function uploadImage(Request $req)
    {
        $this->validate($req, [
            'image' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        # upload to CLoudinary
        $image = Uploader::upload($req->file('image')->getRealPath(), [
            'public_id' => $req->user->customer_id,
            'folder'    => 'customers',
        ]);

        # update photo
        $customer = Customer::find($req->user->customer_id);
        $customer->update(['photo' => $image['secure_url']]);

        if ($image) {
            return response()->json([
                'success'   => true,
                'message'   => 'image uploaded!',
                'profile'   => Customer::find($req->user->customer_id)
            ]);
        }
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
            'message' => 'Profile updated!',
            'profile' => Customer::find($req->user->customer_id)
        ]);
    }

    public function changePassword(Request $req)
    {
        $this->validate($req, [
            'current_password'  => 'required|string',
            'new_password'      => 'required|string',
        ]);

        if (Hash::check($req->current_password, $req->user->password)) {
            Customer::find($req->user->customer_id)->update([
                'password' => Hash::make($req->new_password)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password Changed!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Current password is wrong!'
            ], 401);
        }

        
    }
}