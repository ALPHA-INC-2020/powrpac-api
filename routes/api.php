<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'LoginController@login');
Route::post('/register', 'RegisterController@register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/logout', 'LoginController@logout');
    Route::post('/create/product', 'ProductController@addProduct');
    Route::post('/update/product/{id}', 'ProductController@updateProduct');
    Route::post('/delete/product/{id}', 'ProductController@deleteProduct');
    Route::post('/update/sale/{id}', 'ProductController@updateSaleStatus');
    Route::post('/update/isPopular/{id}', 'ProductController@updatePopular');
    Route::post('/update/isNewRelease/{id}', 'ProductController@updateNewReleased');
});

Route::get('/get/product/popular', 'ProductController@getAllPopularProducts');
Route::get('/get/product/newReleased', 'ProductController@getAllNewReleaseProducts');
Route::get('/get/product', 'ProductController@getAllProducts');
Route::post('/order/product/{id}', 'OrderController@orderProduct');
