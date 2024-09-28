<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    public function getWishlist(Request $request)
    {
        try {

            $authenticatedUser = $request->user();


            $userID = null;
            $designerID = null;

            if ($authenticatedUser instanceof \App\Models\User) {

                $userID = $authenticatedUser->id;
            } elseif ($authenticatedUser instanceof \App\Models\Designer) {

                $designerID = $authenticatedUser->id;
            } else {
                return response()->json(['error' => 'Invalid token.'], 403);
            }


            $wishlist = null;
            if ($userID) {
                $wishlist = Wishlist::with('products.images', 'products.categories', 'products.designer')
                            ->where('user_id', $userID)->first();
            } elseif ($designerID) {
                $wishlist = Wishlist::with('products.images', 'products.categories', 'products.designer')
                            ->where('designer_id', $designerID)->first();
            }


            if (!$wishlist) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Wishlist not found.',
                ], 404);
            }


            return response()->json([
                'status' => 'success',
                'wishlist' => $wishlist,
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function deleteWishlist(Request $request)
    {
        try {

            $authenticatedUser = $request->user();


            $userID = null;
            $designerID = null;

            if ($authenticatedUser instanceof \App\Models\User) {

                $userID = $authenticatedUser->id;
            } elseif ($authenticatedUser instanceof \App\Models\Designer) {

                $designerID = $authenticatedUser->id;
            } else {
                return response()->json(['error' => 'Invalid token.'], 403);
            }


            $wishlist = null;
            if ($userID) {
                $wishlist = Wishlist::where('user_id', $userID)->first();
            } elseif ($designerID) {
                $wishlist = Wishlist::where('designer_id', $designerID)->first();
            }


            if (!$wishlist) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Wishlist not found.',
                ], 404);
            }


            $wishlist->delete();


            return response()->json([
                'status' => 'success',
                'message' => 'Wishlist deleted successfully.',
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function addSingleProduct(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                'status' => 'error',
                'message' => $validator->errors(),
            ]
           , 422);
            }

            $authenticatedUser = $request->user();


            $userID = null;
            $designerID = null;

            if ($authenticatedUser instanceof \App\Models\User) {

                $userID = $authenticatedUser->id;
            } elseif ($authenticatedUser instanceof \App\Models\Designer) {

                $designerID = $authenticatedUser->id;
            } else {
                return response()->json(['error' => 'Invalid token.'], 403);
            }

            $cart = null;
            if ($userID) {
                $cart = Cart::firstOrCreate(['user_id' => $userID]);
            } elseif ($designerID) {
                $cart = Cart::firstOrCreate(['designer_id' => $designerID]);
            }

            if ($cart && $cart->products->contains($request->product_id)) {
                $cart->products()->detach($request->product_id);
            }




            $wishlist = null;
            if ($userID) {
                $wishlist = Wishlist::where('user_id', $userID)->first();
            } elseif ($designerID) {
                $wishlist = Wishlist::where('designer_id', $designerID)->first();
            }


            $product = Product::with('images', 'designer', 'categories')->find($request->product_id);


            $wishlist->products()->syncWithoutDetaching([
                $product->id => ['quantity' => $request->quantity]
            ]);

            $wishlist = $wishlist->load('products');

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to wishlist successfully.',
                'wishlist' => $wishlist,
                'products'=>$product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateSingleProduct(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                'status' => 'error',
                'message' => $validator->errors(),
            ]
           , 422);
            }

            $authenticatedUser = $request->user();


            $userID = null;
            $designerID = null;

            if ($authenticatedUser instanceof \App\Models\User) {

                $userID = $authenticatedUser->id;
            } elseif ($authenticatedUser instanceof \App\Models\Designer) {

                $designerID = $authenticatedUser->id;
            } else {
                return response()->json(['error' => 'Invalid token.'], 403);
            }

            $wishlist = null;
            if ($userID) {
                $wishlist = Wishlist::where('user_id', $userID)->first();
            } elseif ($designerID) {
                $wishlist = Wishlist::where('designer_id', $designerID)->first();
            }

            $product = Product::with('images', 'designer', 'categories')->find($request->product_id);

            if ($request->quantity == 0) {
                $wishlist->products()->detach($product->id);
            } else {
                $wishlist->products()->syncWithoutDetaching([
                    $product->id => ['quantity' => $request->quantity]
                ]);
            }

            $wishlist = $wishlist->load('products');

            return response()->json([
                'status' => 'success',
                'message' => 'Product updated in wishlist successfully.',
                'wishlist' => $wishlist,
                'product'=>$product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function removeSingleProduct(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                'status' => 'error',
                'message' => $validator->errors(),
            ]
           , 422);
            }

            $authenticatedUser = $request->user();


            $userID = null;
            $designerID = null;

            if ($authenticatedUser instanceof \App\Models\User) {

                $userID = $authenticatedUser->id;
            } elseif ($authenticatedUser instanceof \App\Models\Designer) {

                $designerID = $authenticatedUser->id;
            } else {
                return response()->json(['error' => 'Invalid token.'], 403);
            }

            $wishlist = null;
            if ($userID) {
                $wishlist = Wishlist::where('user_id', $userID)->first();
            } elseif ($designerID) {
                $wishlist = Wishlist::where('designer_id', $designerID)->first();
            }

            $product = Product::with('images', 'designer', 'categories')->find($request->product_id);

            $wishlist->products()->detach($product->id);

            $wishlist = $wishlist->load('products');

            return response()->json([
                'status' => 'success',
                'message' => 'Product removed from wishlist successfully.',
                'wishlist' => $wishlist,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
