<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
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
            'isPopular' => $request->isPopular
        ]);

        return response($product, 200)->header('Content-Type', 'application/json');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->model = $request->model;

        $product->productName = $request->productName;

        $product->navigator = str_replace(' ', '_', $request->productName);

        $product->brand = $request->brand;

        $product->rating = $request->rating;

        $product->realPrice = $request->realPrice;

        $product->promoPrice = $request->promoPrice;

        $product->type = $request->type;

        $product->productType = $request->productType;

        $product->sale = $request->sale;

        $product->details = $request->details;

        $product->imageURLs = $request->imageURLs ? $request->imageURLs : $product->imageURLs;

        $product->save();
        return response(['updatedProduct', $product], 200)->header('Content-Type', 'application/json');
    }

    public function getAllProducts()
    {
        $products = Product::all();
        return response(['products', $products], 200)->header('Content-Type', 'application/json');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response('Delete Sucesss', 200);
    }

    public function updateSaleStatus(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->sale = $request->sale;
        $product->save();
        return response('Status Updated!', 200);
    }

    public function updatePopular(Request $request, $id){
        $product = Product::findOrFail($id);
        $product->isPopular = !$request->isPopular;
        $product->save();
        return response('Make Popular Product!', 200);
    }

    public function updateNewReleased(Request $request, $id){
        $product = Product::findOrFail($id);
        $product->isNewRelease = !$request->isNewRelease;
        $product->save();
        return response('Make New Released Product', 200);
    }

    public function getAllPopularProducts(){
        $popular_products = Product::where('isPopular' , true)->get();
        return response( $popular_products, 200)->header('Content-Type', 'application/json');
    }

    public function getAllNewReleaseProducts(){
        $new_released_products = Product::where('isNewRelease' , true)->get();
        return response($new_released_products, 200)->header('Content-Type', 'application/json');
    }
}
