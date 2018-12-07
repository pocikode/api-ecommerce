<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.admin', ['only' => ['profile']]);
    }

    // function to create jwt token
    protected function jwt($user)
    {
        // set payload
        $payload = [
            'level' => 'admin',
            'sub'   => $user->user_id,
            'iat'   => time(),
            'exp'   => time() + 60 * 60 * 24
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function auth(Request $req)
    {
        // validate form-data
        $this->validate($req, [
            'username' => 'required',
            'password'  => 'required'
        ]);
        
        // validation username
        $user = User::where('username', $req->username)->first();
        if (!$user) {
            return response()->json(['error' => 'Username is Not Exists!'], 401);
        }

        // validation password
        if (Hash::check($req->password, $user->password)) {
            return response()->json([
                'success'   => true,
                'message'   => 'Login Successfull',
                'token'     => $this->jwt($user)
            ]);
        } else {
            return response()->json(['error' => 'Wrong Password!'], 401);
        }
    }
}