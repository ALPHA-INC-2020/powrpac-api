<?php

namespace App\Http\Controllers;

use App\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function productNotFound()
    {
        return response()->json(['message' => 'product not found'], 404);

    }

    public function errorMsg()
    {
        return response()->json(['message' => 'error'], 404);
    }
    public function addProduct(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'model' => 'required',
                'productName' => 'required',
                'navigator' => 'required',
                'brand' => 'required',
                'rating' => 'required',
                'promoPrice' => 'required',
                'type' => 'required',
                'productType' => 'required',
                'sale' => 'required',
                'details' => 'required',
                'imageURLs' => 'required',
            ]);
            $product = Product::create([
                'model' => $validatedData['model'],
                'productName' => $validatedData['productName'],
                'navigator' => $validatedData['navigator'],
                'brand' => $validatedData['brand'],
                'rating' => $validatedData['rating'],
                'realPrice' => $request->realPrice,
                'promoPrice' => $validatedData['promoPrice'],
                'type' => $validatedData['type'],
                'productType' => $validatedData['productType'],
                'sale' => $validatedData['sale'],
                'details' => $validatedData['details'],
                'imageURLs' => $validatedData['imageURLs'],
                'isNewRelease' => $request->isNewRelease,
                'isPopular' => $request->isPopular,
            ]);

        } catch (ModelNotFoundException $e) {
            return $this->errorMsg();
        }

        return response($product, 200)->header('Content-Type', 'application/json');
    }

    public function updateProduct(Request $request, $id)
    {

        try {
            $product = Product::findOrFail($id);

            if ($request->model) {
                $product->model = $request->model;
            }
            if ($request->productName) {
                $product->productName = $request->productName;
                $product->navigator = str_replace(' ', '_', $request->productName);

            }
            if ($request->brand) {
                $product->brand = $request->brand;
            }

            if ($request->rating) {
                $product->rating = $request->rating;
            }

            if ($request->realPrice) {
                $product->realPrice = $request->realPrice;
            }

            if ($request->promoPrice) {
                $product->promoPrice = $request->promoPrice;
            }

            if ($request->type) {
                $product->type = $request->type;
            }

            if ($request->productType) {
                $product->productType = $request->productType;
            }

            if ($request->sale) {
                $product->sale = $request->sale;
            }

            if ($request->details) {
                $product->details = $request->details;
            }

            if ($request->imageURLs) {
                $product->imageURLs = $request->imageURLs;
            }

            $product->save();
            return response(['updatedProduct', $product], 200)->header('Content-Type', 'application/json');

        } catch (ModelNotFoundException $e) {
            return $this->productNotFound();
        }

    }

    public function getAllProducts()
    {
        $products = Product::with('user')->get();
        return response($products, 200)->header('Content-Type', 'application/json');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response('Delete Sucesss', 200);
    }

    public function updateSaleStatus(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->sale = $request->status;
            $product->save();
            return response('Status Updated!', 200);
        } catch (ModelNotFoundException $e) {
            return $this->productNotFound();
        }

    }

    public function updatePopular(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->isPopular = !$request->isPopular;
            $product->save();
            return response('Make Popular Product!', 200);

        } catch (ModelNotFoundException $e) {
            return $this->productNotFound();
        }
    }

    public function updateNewReleased(Request $request, $id)
    {

        try {
            $product = Product::findOrFail($id);
            $product->isNewRelease = !$request->isNewRelease;
            $product->save();
            return response('Make New Released Product', 200);

        } catch (ModelNotFoundException $e) {
            return $this->productNotFound();
        }

    }

    public function getAllPopularProducts()
    {
        $popular_products = Product::where('isPopular', true)->get();
        return response($popular_products, 200)->header('Content-Type', 'application/json');
    }

    public function getAllNewReleaseProducts()
    {
        $new_released_products = Product::where('isNewRelease', true)->get();
        return response($new_released_products, 200)->header('Content-Type', 'application/json');
    }

    public function getRecentAddedProducts()
    {
        $fromDate = Carbon::yesterday();
        $toDate = Carbon::tomorrow();
        $recent = Product::select('productName', 'model', 'created_at', 'user_id')->whereBetween('created_at', [$fromDate->toDateString(), $toDate->toDateString()])->with(['user' => function ($query) {
            $query->select('id', 'name');
        }])->get();
        return response()->json(['message' => 'recent added products', 'data' => $recent]);
    }

    public function getChart()
    {

        $productByMonth = Product::select('created_at')
            ->get()
            ->groupBy(function ($date) {
                // return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return Carbon::parse($date->created_at)->format('m'); // grouping by months
            });

        $collections = [];

        for ($i = 0; $i < 12; $i++) {
            $collections[$i] = 0;
        }
        foreach ($productByMonth as $key => $value) {

            $collections[(int) $key - 1] = count($value);
        }

        return response($collections, 200);
    }
}
