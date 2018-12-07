<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.admin');
    }

    public function show(Request $req)
    {
        return response()->json([
            'success' => true,
            'data' => $req->user
        ]);
    }

    public function update(Request $req)
    {
        $user = User::find($req->user->user_id);
        $user->update($req->all());
        return response()->json([
            'success' =>true,
            'message' => 'Profile Updated!'
        ]);
    }
}