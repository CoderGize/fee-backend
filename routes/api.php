<?php

use App\Http\Controllers\Api\Auth\AuthDesignerController;
use App\Http\Controllers\Api\Auth\AuthUserController;
use App\Http\Controllers\Api\Cart\CartController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Designer\DesignerController;
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
        Route::delete('/products/{id}', [ProductController::class, 'delete']);

        Route::get('/sold-products', [DesignerController::class, 'getSoldProducts']);

        Route::prefix('categories')->group(function () {
            Route::post('/create', [CategoryController::class, 'create']);
            Route::get('/', [CategoryController::class, 'index']);
        });

        Route::post('update-profile', [AuthDesignerController::class, 'updateProfile']);
        Route::post('change-password', [AuthDesignerController::class, 'changePassword']);
        Route::post('change-username', [AuthDesignerController::class, 'changeUsername']);
    });

    Route::prefix('user')->group(function (){

        Route::post('update-profile', [AuthUserController::class, 'updateProfile']);
        Route::post('change-password', [AuthUserController::class, 'changePassword']);
        Route::post('change-username', [AuthUserController::class, 'changeUsername']);

        Route::get('/designer', [DesignerController::class, 'search']);
        //product
        Route::get('products', [ProductController::class, 'index']);
        Route::get('products/{id}', [ProductController::class, 'getProductById']);
        Route::get('/products/designer', [ProductController::class, 'getDesignerProductsForUsers']);

        // cart
        Route::post('cart/add', [CartController::class, 'addToCart']);
        Route::post('cart/update', [CartController::class, 'updateCart']);
        Route::get('cart', [CartController::class, 'getCart']);
        Route::delete('cart', [CartController::class, 'deleteCart']);

        // single product cart

        Route::post('cart/add/single', [CartController::class, 'addSingleProduct']);
        Route::post('cart/update/single', [CartController::class, 'updateSingleProduct']);
        Route::post('cart/remove/single', [CartController::class, 'removeSingleProduct']);


        //order
        Route::post('order/create', [OrderController::class, 'createOrder']);
        Route::post('order/update/{id}', [OrderController::class, 'updateOrder']);
        Route::get('order', [OrderController::class, 'getUserOrders']);
        Route::get('order/{id}', [OrderController::class, 'getOrder']);
        Route::delete('order/delete/{id}', [OrderController::class, 'deleteOrder']);


        Route::post('orders/{id}/confirm', [OrderController::class, 'confirmOrder']);
        Route::post('orders/{id}/complete-checkout', [OrderController::class, 'completeCheckout']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
