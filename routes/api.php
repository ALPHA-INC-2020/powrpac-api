<?php

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
    Route::post('/change/name', 'ProfileController@changeUserName');

    //get admin(user) profile
    Route::get('/get/profile', 'ProfileController@getProfileInfo');

    //auth
    Route::post('/logout', 'LoginController@logout');

    //product
    Route::get('/product/get/recent', 'ProductController@getRecentAddedProducts');
    Route::post('/create/product', 'ProductController@addProduct');
    Route::post('/update/product/{id}', 'ProductController@updateProduct');
    Route::post('/delete/product/{id}', 'ProductController@deleteProduct');
    Route::get('/get/product/date', 'ProductController@getChart');
    Route::post('/update/sale/{id}', 'ProductController@updateSaleStatus');
    Route::post('/update/isPopular/{id}', 'ProductController@updatePopular');
    Route::post('/update/isNewRelease/{id}', 'ProductController@updateNewReleased');

    //order
    Route::get('/order/get/recent', 'OrderController@getRecentOrders');
    Route::get('/order/get/today', 'OrderController@getTodayOrders');
    Route::get('/order/get/total_sale', 'OrderController@getTotalSale');
    Route::get('/get/order/date', 'OrderController@getChart');
    Route::get('/get/order/sale/chart', 'OrderController@getSaleChart');
    Route::post('/order/updateStatus/{id}', 'OrderController@updateOrderStatus');
    Route::post('/delete/order/{id}', 'OrderController@deleteOrder');

    //banner
    Route::get('/get/banner', 'BannerController@getAllBanners');
    Route::post('/delete/banner/{id}', 'BannerController@deleteBanner');
    Route::post('/set/banner/active/{id}', 'BannerController@setActiveBanner');
    Route::post('/create/banner', 'BannerController@createNewBanner');

    //promotion
    Route::post('/create/promotion', 'PromotionController@createNewPromotion');
    Route::get('/get/promotion', 'PromotionController@getAllPromotions');
    Route::post('/set/promotion/active/{id}', 'PromotionController@setActivePromotion');
    Route::post('/delete/promotion/{id}', 'PromotionController@deletePromotion');

    //faq
    Route::post('/create/faq', 'faqController@createFAQ');
    Route::post('/delete/faq/{id}', 'faqController@deleteFAQ');
    Route::post('/update/faq/{id}', 'faqController@updateFAQ');

    //change password
    Route::post('/change/password', 'ProfileController@changePass');

    //get all contact messages
    Route::get('/get/message', 'ContactController@getAllMsgs');

});

//(public routes)
//promotion
Route::get('/get/promotion/active', 'PromotionController@getAllActivePromotions');

//product
Route::get('/get/product/popular', 'ProductController@getAllPopularProducts');
Route::get('/get/product/newReleased', 'ProductController@getAllNewReleaseProducts');
Route::get('/get/product', 'ProductController@getAllProducts');

//order
Route::get('/get/order', 'OrderController@getAllOrders');
Route::post('/order/product/{id}', 'OrderController@orderProduct');

//banner
Route::get('/get/banner/active', 'BannerController@getActiveBanner');

//faq
Route::get('/get/faqs', 'faqController@getAllFAQs');

//ewarranty
Route::post('/create/ewarranty', 'WarrantyController@createWarranty');

//send msg
Route::post('/send/msg', 'ContactController@createMsg');


