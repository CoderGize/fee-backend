<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
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
            $user = Auth::user();

            $wishlist = Wishlist::with('products.images','products.categories','products.designer')->where('user_id', $user->id)->first();

            if (!$wishlist) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'wishlist not found.',
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

    public function deleteWishlist()
    {
        try {
            $user = Auth::user();

            $wishlist = Wishlist::where('user_id', $user->id)->first();

            if (!$wishlist) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'wishlist not found.',
                ], 404);
            }

            $wishlist->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'wishlist deleted successfully.',
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
                return response()->json($validator->errors(), 422);
            }

            $user = Auth::user();

            $wishlist = Wishlist::firstOrCreate(['user_id' => $user->id]);

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
                return response()->json($validator->errors(), 422);
            }

            $user = Auth::user();

            $wishlist = Wishlist::firstOrCreate(['user_id' => $user->id]);

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
                return response()->json($validator->errors(), 422);
            }

            $user = Auth::user();

            $wishlist = Wishlist::firstOrCreate(['user_id' => $user->id]);

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
