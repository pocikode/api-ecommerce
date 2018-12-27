<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Cloudinary\Uploader;

class ProfileController extends Controller
{
    public function __construct()
    {
        # set middleware
        $this->middleware('jwt.admin');
    }

    # show profile info
    public function show(Request $req)
    {
        return response()->json([
            'success' => true,
            'data' => $req->user
        ]);
    }

    # update profile
    public function update(Request $req)
    {
        $user = User::find($req->user->user_id)->update($req->all());
        return response()->json([
            'success' => true,
            'message' => 'Profile Updated!',
            'profile' => User::find($req->user->user_id)->update($req->all())
        ]);
    }

    # upload image
    public function uploadImage(Request $req)
    {
        # validate data form
        $this->validate($req, [
            'image' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        # upload to Cloudinary
        $image = Uploader::upload($req->file('image'), [
            'public_id' => $req->user->user_id,
            'folder'    => 'users'
        ]);

        if ($image) {
            return response()->json([
                'success' => true,
                'message' => 'image uploaded!',
                'url'     => $image['secure_url']
            ]);
        }
    }

    # change password
    public function changePassword(Request $req)
    {
        $this->validate($req, [
            'current_password'  => 'required|string',
            'new_password'      => 'required|string',
        ]);

        # if current password is match
        if (Hash::check($req->current_password, $req->user->password)) {
            # update password
            User::find($req->user->user_id)->update([
                'password' => Hash::make($req->new_password)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password changed'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Current Password is wrong',
            ], 401);
        }
    }
}