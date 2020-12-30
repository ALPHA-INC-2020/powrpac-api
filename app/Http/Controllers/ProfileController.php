<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function getProfileInfo()
    {
        return auth()->user();
    }

    public function changePass(Request $req)
    {
        $old_pass = auth()->user()->password;
        if (Hash::check($req->current_password, $old_pass)) {
            User::find(auth()->user()->id)->update(['password' => Hash::make($req->confirm_password)]);
            return response('success', 200);
        } else {
            return response('error', 404);
        }
    }

    public function changeUserName(Request $req)
    {
        try {
            User::find(auth()->user()->id)->update(['name' => $req->name]);

            return response('success', 200);

        } catch (ModelNotFoundException $e) {
            return response('error on updating name');
        }

    }
}
