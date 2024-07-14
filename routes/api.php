<?php

use App\Http\Controllers\Api\Auth\AuthDesignerController;
use App\Http\Controllers\Api\Auth\AuthUserController;
use App\Http\Controllers\Api\Cart\CartController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Product\ProductController;
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

Route::prefix('user')->group(function () {
    Route::post('signup', [AuthUserController::class, 'register']);
    Route::post('login', [AuthUserController::class, 'login']);
    Route::post('verify-otp', [AuthUserController::class, 'verifyOtp']);
    Route::post('forgot-password', [AuthUserController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthUserController::class, 'resetPassword']);
});

Route::prefix('designer')->group(function () {
    Route::post('signup', [AuthDesignerController::class, 'register']);
    Route::post('login', [AuthDesignerController::class, 'login']);
    Route::post('verify-otp', [AuthDesignerController::class, 'verifyOtp']);
    Route::post('forgot-password', [AuthDesignerController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthDesignerController::class, 'resetPassword']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('designer')->group(function (){
        Route::post('/products', [ProductController::class, 'create']);
        Route::post('/products/update/{id}', [ProductController::class, 'update']);
        Route::get('/products/designer', [ProductController::class, 'getDesignerProducts']);
        Route::delete('products/{id}', [ProductController::class, 'delete']);
    });

    Route::prefix('user')->group(function (){
        //product
        Route::get('products', [ProductController::class, 'index']);
        Route::get('/products/designer', [ProductController::class, 'getDesignerProductsForUsers']);

        // cart
        Route::post('cart/add', [CartController::class, 'addToCart']);
        Route::post('cart/update', [CartController::class, 'updateCart']);
        Route::get('cart', [CartController::class, 'getCart']);
        Route::delete('cart', [CartController::class, 'deleteCart']);


        //order
        Route::post('order/create', [OrderController::class, 'createOrder']);
        Route::post('order/update/{id}', [OrderController::class, 'updateOrder']);
        Route::get('order', [OrderController::class, 'getUserOrders']);
        Route::get('order/{id}', [OrderController::class, 'getOrder']);
        Route::delete('order/delete/{id}', [OrderController::class, 'deleteOrder']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
