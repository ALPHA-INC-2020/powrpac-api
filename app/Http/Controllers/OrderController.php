<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Carbon\Carbon;
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

    public function getRecentOrders()
    {
        $recentOrder = Order::select('customer_name', 'customer_address', 'created_at', 'phone_no')->whereDate('created_at', Carbon::today())->get();

        return response()->json(['message' => 'recent orders', 'data' => $recentOrder]);
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

    public function getChart()
    {

        $productByMonth = Order::select('created_at')
            ->get()
            ->groupBy(function ($date) {
                // return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return Carbon::parse($date->created_at)->format('m'); // grouping by months
            });

        $collections = [];

        for ($i = 0; $i < 13; $i++) {
            $collections[$i] = 0;
        }
        foreach ($productByMonth as $key => $value) {

            $collections[(int) $key] = count($value);
        }

        return response($collections, 200);
    }
}
