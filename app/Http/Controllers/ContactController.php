<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function createMsg(Request $req) {
        $validatedData = $req->validate([
            "name" => 'required',
            "content" => 'required',
            "email" => 'required'
        ]);

        $success_msg = false;

            try {
                $new_msg = Contact::create([
                    'name' => $validatedData['name'],
                    'content' => $validatedData['content'],
                    'email' => $validatedData['email'],
                    'phone_number' => $req->phone_number
                ]);

                $success_msg = true;
                $status_code = 200;
            } catch(ModelNotFoundException $e) {
                $success_msg = false;
            $status_code = 404;
            }
    

        return response()->json(['response_data' => $new_msg, 'success' => $success_msg], $status_code);
    }
}
