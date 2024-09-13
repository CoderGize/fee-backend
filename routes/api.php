<?php

use App\Http\Controllers\Api\Auth\AuthDesignerController;
use App\Http\Controllers\Api\Auth\AuthUserController;
use App\Http\Controllers\Api\Cart\CartController;
use App\Http\Controllers\Api\Cart\WishlistController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\DebtCard\DebtCardController;
use App\Http\Controllers\Api\Designer\DesignerController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Web\ContentApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Content\DesignLetterWebController;
use App\Http\Controllers\Web\Content\NewsLetterWebController;

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
    Route::get('/designer/new/products', [ProductController::class, 'getDesignerProductsForUsers_new']);
    Route::get('products/{id}', [ProductController::class, 'getProductById']);

    Route::get('/designer', [DesignerController::class, 'search']);
    Route::get('/new/products', [ProductController::class, 'new_user']);
    Route::get('/collections', [ProductController::class, 'collections_new']);
    Route::get('/categories', [CategoryController::class, 'index_new']);
    Route::get('/categories/{categoryId}/subcategories', [CategoryController::class, 'getSubcategories']);

    Route::post('/validate-promo-code', [OrderController::class, 'validatePromoCode']);

});

Route::prefix('designer')->group(function () {
    Route::post('signup', [AuthDesignerController::class, 'register']);
    Route::post('login', [AuthDesignerController::class, 'login']);
    Route::post('verify-otp', [AuthDesignerController::class, 'verifyOtp']);
    Route::post('forgot-password', [AuthDesignerController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthDesignerController::class, 'resetPassword']);
});


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/subcategories', [CategoryController::class, 'createSubcategory']);
    Route::prefix('designer')->group(function (){
        Route::delete('logout', [AuthDesignerController::class, 'logout']);
        Route::post('/products', [ProductController::class, 'create']);
        Route::post('/products/update/{id}', [ProductController::class, 'update']);
        Route::get('/products/designer', [ProductController::class, 'getDesignerProducts']);
        Route::delete('/products/{id}', [ProductController::class, 'delete']);
        Route::put('/products/{productId}/discount', [ProductController::class, 'updateDiscount']);

        Route::get('/sold-products', [DesignerController::class, 'getSoldProducts']);

        Route::prefix('categories')->group(function () {
            Route::post('/create', [CategoryController::class, 'create']);
            Route::get('/', [CategoryController::class, 'index']);
        });

        Route::post('update-profile', [AuthDesignerController::class, 'updateProfile']);
        Route::post('change-password', [AuthDesignerController::class, 'changePassword']);
        Route::post('change-username', [AuthDesignerController::class, 'changeUsername']);

        Route::delete('delete-profile-image', [AuthDesignerController::class, 'deleteImage']);
        Route::get('/get_user', [AuthDesignerController::class, 'getUserWithData']);
    });

    Route::prefix('user')->group(function (){
        Route::get('/designer/products', [ProductController::class, 'getDesignerProductsForUsers']);

        Route::get('products', [ProductController::class, 'index']);
        Route::delete('logout', [AuthUserController::class, 'logout']);
        Route::post('update-profile', [AuthUserController::class, 'updateProfile']);
        Route::post('change-password', [AuthUserController::class, 'changePassword']);
        Route::post('change-username', [AuthUserController::class, 'changeUsername']);
        Route::delete('delete-profile-image', [AuthUserController::class, 'deleteImage']);
        Route::get('/get_user', [AuthUserController::class, 'getUserWithData']);

        Route::get('/categories', [CategoryController::class, 'index']);


        //product

        // cart
        Route::post('cart/add', [CartController::class, 'addToCart']);
        Route::post('cart/update', [CartController::class, 'updateCart']);
        Route::get('cart', [CartController::class, 'getCart']);
        Route::delete('cart', [CartController::class, 'deleteCart']);

        // single product cart

        Route::post('cart/add/single', [CartController::class, 'addSingleProduct']);
        Route::post('cart/update/single', [CartController::class, 'updateSingleProduct']);
        Route::post('cart/remove/single', [CartController::class, 'removeSingleProduct']);

        Route::post('wishlist/add/single', [WishlistController::class, 'addSingleProduct']);
        Route::post('wishlist/update/single', [WishlistController::class, 'updateSingleProduct']);
        Route::post('wishlist/remove/single', [WishlistController::class, 'removeSingleProduct']);
        Route::get('wishlists',[WishlistController::class,"getWishlist"]);






        Route::get('/debt-cards', [DebtCardController::class, 'index']);
        Route::get('/debt-cards/{id}', [DebtCardController::class, 'show']);
        Route::post('/debt-cards', [DebtCardController::class, 'store']);
        Route::post('/debt-cards/{id}', [DebtCardController::class, 'update']);
        Route::delete('/debt-cards/{id}', [DebtCardController::class, 'destroy']);


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


/*
|--------------------------------------------------------------------------
| Web Content API
|--------------------------------------------------------------------------
*/
Route::get('/get-about', [ContentApiController::class, 'getAbout']);
Route::get('/get-become-designer', [ContentApiController::class, 'getBecomeDesigner']);
Route::get('/get-become-designer-benefit', [ContentApiController::class, 'getBecomeDesignerBenefit']);
Route::get('/get-blog', [ContentApiController::class, 'getBlog']);
Route::get('/get-carousel', [ContentApiController::class, 'getCarousel']);
Route::get('/get-contact', [ContentApiController::class, 'getContactWeb']);
Route::get('/get-designer-story', [ContentApiController::class, 'getDesignerStory']);
Route::get('/get-download', [ContentApiController::class, 'getDownload']);
Route::get('/get-instagrid', [ContentApiController::class, 'getInstagrid']);
Route::get('/get-landing', [ContentApiController::class, 'getLanding']);
Route::get('/get-show', [ContentApiController::class, 'getShow']);
Route::get('/get-showroom', [ContentApiController::class, 'getShowroom']);
Route::get('/get-social', [ContentApiController::class, 'getSocial']);
Route::get('/get-testimonial', [ContentApiController::class, 'getTestimonial']);

Route::post('/add-newsletter', [NewsLetterWebController::class, 'add_newsletter']);
Route::post('/add-designletter', [DesignLetterWebController::class, 'add_designletter']);
