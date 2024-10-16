<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'cart' => 'required|array',
                'cart.*.product_id' => 'required|exists:products,id',
                'cart.*.quantity' => 'required|integer|min:1',
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


            foreach ($request->cart as $item) {

                $product = Product::find($item['product_id']);


                $cart->products()->syncWithoutDetaching([
                    $product->id => ['quantity' => $item['quantity']]
                ]);
            }


            $cart = $cart->load('products');



            return response()->json([
                'status' => 'success',
                'message' => 'Products added to cart successfully.',
                'cart' => $cart,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateCart(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'cart' => 'required|array',
                'cart.*.product_id' => 'required|exists:products,id',
                'cart.*.quantity' => 'required|integer|min:0',
            ]);

            if ($validator->fails()) {
                    return response()->json(
                        [
                    'status' => 'error',
                    'message' => $validator->errors(),
                ]
               , 422);
                }
            $user = Auth::user();

            $cart = Cart::firstOrCreate(['user_id' => $user->id]);

            foreach ($request->cart as $item) {
                if ($item['quantity'] == 0) {

                    $cart->products()->detach($item['product_id']);
                } else {

                    $cart->products()->syncWithoutDetaching([
                        $item['product_id'] => ['quantity' => $item['quantity']]
                    ]);
                }
            }

            $cart = $cart->load('products');

            return response()->json([
                'status' => 'success',
                'message' => 'Cart updated successfully.',
                'cart' => $cart,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getCart(Request $request)
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

            $cart = null;

            if ($userID) {

                $cart = Cart::with('products.images')->where('user_id', $userID)->first();
            } elseif ($designerID) {

                $cart = Cart::with('products.images')->where(['designer_id' => $designerID])->first();
            }


            if (!$cart) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cart not found.',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'cart' => $cart,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteCart(Request $request)
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


                $cart = null;

                if ($userID) {
                    $cart = Cart::where('user_id', $userID)->first();
                } elseif ($designerID) {
                    $cart = Cart::where('designer_id', $designerID)->first();
                }


                if (!$cart) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Cart not found.',
                    ], 404);
                }



            $cart->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Cart deleted successfully.',
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
                'size'=>'required|string',
                'color'=>'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
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


            if ($wishlist && $wishlist->products->contains($request->product_id)) {
                $wishlist->products()->detach($request->product_id);
            }


            $cart = null;
            if ($userID) {
                $cart = Cart::firstOrCreate(['user_id' => $userID]);
            } elseif ($designerID) {
                $cart = Cart::firstOrCreate(['designer_id' => $designerID]);
            }


            $product = Product::with('images', 'designer', 'categories')->find($request->product_id);


            $cart->products()->syncWithoutDetaching([
                $product->id => [
                    'quantity' => $request->quantity,
                    'color'=>$request->color,
                    'size'=>$request->size]
            ]);


            $cart = $cart->load('products');


            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart successfully.',
                'cart' => $cart,
                'product' => $product
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
                'size'=>'required|string',
                'color'=>'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
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


            $product = Product::with('images', 'designer', 'categories')->find($request->product_id);

            if ($request->quantity == 0) {
                $cart->products()->detach($product->id);
            } else {

                $cart->products()->syncWithoutDetaching([
                    $product->id => [
                    'quantity' => $request->quantity,
                    'color'=>$request->color,
                    'size'=>$request->size]
                ]);
            }


            $cart = $cart->load('products');


            return response()->json([
                'status' => 'success',
                'message' => 'Product updated in cart successfully.',
                'cart' => $cart,
                'product' => $product
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


            $product = Product::with('images', 'designer', 'categories')->find($request->product_id);


            $cart->products()->detach($product->id);


            $cart = $cart->load('products');


            return response()->json([
                'status' => 'success',
                'message' => 'Product removed from cart successfully.',
                'cart' => $cart,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
