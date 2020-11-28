<?php

namespace App\Http\Controllers;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orderProduct(Request $req, $id) {
        $validatedData = $req->validate([
            'customer_name' => 'required',
            'customer_address' => 'required',
            'order_status' => 'required'            
        ]);

        $order =Order::create([
            'product_id' => $id,
            'customer_name' => $validatedData['customer_name'],
            'customer_address' => $validatedData['customer_address'],
            'email' => $req->customer_email ? $req->customer_email : 'unknown@gmail.com',
            'phone_no' => $req->phone_no ? $req->phone_no : '09 - xxxxxxx',
            'note' => $req->note ? $req->note : 'no note',
            'order_status'=> $validatedData['order_status']
        ]);


        return response($order, 200)->header('Content-Type', 'application/json');
    }

    public function getAllOrders(){
        return response(Order::with('product')->orderBy('id', 'desc')->get(),200)->header('Content-Type', 'application/json');
    }
}
