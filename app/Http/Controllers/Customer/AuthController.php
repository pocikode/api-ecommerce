<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use App\Models\Customer;
use Illuminate\Http\Request;

/**
 * Customer Auth
 */
class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    # create jwt token
    private function jwt($customer)
    {
        $payload = [
            'level' => 'customer',
            'sub'   => $customer->customer_id,
            'iat'   => time(),
            'exp'   => time() + 60*60*24
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }

    # register new account
    public function register(Request $req)
    {
        $this->validate($req, [
            'name'  => 'required',
            'phone' => 'required|min:6|max:15',
            'email' => 'required|email|max:100',
            'password' => 'required|min:8|max:100'
        ]);

        $data = Customer::Create([
            'name'  => $req->name,
            'phone' => $req->phone,
            'email' => $req->email,
            'password' => $req->password
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Account Created!',
            'data'    => $data,
            'token'   => $this->jwt($data)
        ]);
    }

    
}
