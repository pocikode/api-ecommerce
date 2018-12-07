<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $this->middleware('jwt.customer', ['only' => ['profile']]);
    }

    # create jwt token
    private function jwt($customer)
    {
        # set token payload
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
        # validate form-data
        $this->validate($req, [
            'name'  => 'required',
            'phone' => 'required|min:6|max:15',
            'email' => 'required|email|max:100',
            'password' => 'required|min:8|max:100'
        ]);
        
        # store data
        $data = Customer::Create([
            'name'  => $req->name,
            'phone' => $req->phone,
            'email' => $req->email,
            'password' => Hash::make($req->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Account Created!',
            'data'    => $data,
            'token'   => $this->jwt($data)
        ]);
    }

    # login
    public function login(Request $req)
    {
        # validate form-data
        $this->validate($req, [
            'email' => 'required',
            'password' => 'required'
        ]);
        
        # check email field
        $field = filter_var($req->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $customer = Customer::where($field, $req->email)->first();
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Email or Phone not found!'
            ], 401);
        }

        # check password
        if (Hash::check($req->password, $customer->password)) {
            return response()->json([
                'success' => true,
                'message' => 'Login SUccessfull!',
                'token'   => $this->jwt($customer)
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Wrong password!',
            ], 401);
        }
    }
}
