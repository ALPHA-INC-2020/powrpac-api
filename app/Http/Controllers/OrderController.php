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
                'total_cost' => 'required',
            ]);

            $order = Order::create([
                'product_id' => $id,
                'customer_name' => $validatedData['customer_name'],
                'customer_address' => $validatedData['customer_address'],
                'email' => $req->customer_email ? $req->customer_email : 'unknown@gmail.com',
                'total_cost' => $validatedData['total_cost'],
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
        $fromDate = Carbon::yesterday();
        $toDate = Carbon::tomorrow();

        $recent = Order::select('customer_name', 'customer_address', 'created_at', 'phone_no', 'purchase_type')->whereBetween('created_at', [$fromDate->toDateString(), $toDate->toDateString()])->get();
        return response()->json(['message' => 'recent orders', 'data' => $recent]);
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

        $orderByMonth = Order::select('created_at')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('m');
            });

        $collections = [];

        for ($i = 0; $i < 12; $i++) {
            $collections[$i] = 0;
        }
        foreach ($orderByMonth as $key => $value) {
            $collections[(int) $key - 1] = count($value);
        }

        return response($collections, 200);
    }
    public function getTotalCost($totalCost)
    {
        $cost = 0;
        foreach ($totalCost as $tc) {
            $cost += $tc->total_cost;
        }
        return $cost;
    }

    public function getSaleChart()
    {

        $saleByMonth = Order::select('created_at', 'total_cost')->where('order_status', 'complete')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('m');
            });

        $collections = [];
        for ($i = 0; $i < 12; $i++) {
            $collections[$i] = 0;
        }
        foreach ($saleByMonth as $key => $value) {
            $collections[(int) $key - 1] = $this->getTotalCost($value);
        }
        return response($collections, 200);

    }

    public function getTodayOrders()
    {
        $orders_today = Order::whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->count();
        return response($orders_today, 200);
    }

    public function getTotalSale()
    {
        $total_sale = Order::select('total_cost')->where('order_status', 'complete')->get();
        $sales = 0;

        foreach ($total_sale as $value) {
            $sales += $value['total_cost'];

        }
        return response($sales, 200);
    }

}
