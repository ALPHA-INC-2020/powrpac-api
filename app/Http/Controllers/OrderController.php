<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orderProduct(Request $req, $id)
    {

        try {

            Product::findOrFail($id);
            $validatedData = $req->validate([
                'customer_name' => 'required',
                'customer_address' => 'required',
                'order_status' => 'required',
            ]);

            $order = Order::create([
                'product_id' => $id,
                'customer_name' => $validatedData['customer_name'],
                'customer_address' => $validatedData['customer_address'],
                'email' => $req->customer_email ? $req->customer_email : 'unknown@gmail.com',
                'phone_no' => $req->phone_no ? $req->phone_no : '09 - xxxxxxx',
                'note' => $req->note ? $req->note : 'no note',
                'order_status' => $validatedData['order_status'],
            ]);
            return response($order, 200)->header('Content-Type', 'application/json');

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'not found']);
        }

    }

    public function getAllOrders()
    {

        $order = Order::with('product')->orderBy('id', 'desc')->get();
        if (count($order)) {
            return response($order, 200)->header('Content-Type', 'application/json');
        } else {
            return response()->json(['message' => 'no order'], 404);
        }
    }

    public function updateOrderStatus(Request $res, $id)
    {
        $order = Order::find($id);
        $order->order_status = $res->status;
        $order->save();
        return response($order, 200)->header('Content-Type', 'application/json');
    }

    public function deleteOrder($id)
    {

        try { $order = Order::findOrFail($id);
            $order->delete();
            return response('Delete Sucesss', 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'order not found']);
        }

    }
}
