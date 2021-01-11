<?php

namespace App\Http\Controllers;

use App\Warranty;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{


    public function createWarranty (Request $req) {
        $validatedData = $req->validate([
            'name' => 'required',
            'birthday' => 'required',
            'phone_number' => 'required',
            'township' => 'required',
            'address' => 'required',
            'start_buying_date' => 'required',
            'purchase_from' => 'required',
            'product_model_no' => 'required',
            'product_serial_no' => 'required',
            'warranty_card_img' => 'required'
        ]);
        $success_msg = false;
        

        try{
            $new_warranty = Warranty::create([
                'name' => $validatedData['name'],
                'birthday' => $validatedData['birthday'],
                'phone_number' => $validatedData['phone_number'],
                'township' => $validatedData['township'],
                'address' => $validatedData['address'],
                'start_buying_date' => $validatedData['start_buying_date'],
                'purchase_from' => $validatedData['purchase_from'],
                'product_model_no' => $validatedData['product_model_no'],
                'product_serial_no' => $validatedData['product_serial_no'],
                'warranty_card_img' => $validatedData['warranty_card_img']
            ]);

            $success_msg = true;
            $status_code = 200;
        } catch (ModelNotFoundException $e) {
            $success_msg = false;
            $status_code = 404;

        
        }

        return response()->json(['data' => $new_warranty, 'success' => $success_msg], $status_code);

        
    }
}
