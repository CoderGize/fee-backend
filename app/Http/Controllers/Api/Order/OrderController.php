<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MyFatoorahController;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'products' => 'required|array',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1',
                'promo_code' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'products' => $request->products,
                    'message' => $validator->errors(),
                ], 422);
            }

            $user = Auth::user();

            // Create Order
            $order = new Order();
            $order->user_id = $user->id;
            $order->total_price = 0;
            $order->status = 'pending';

            $order->save();

            $totalPrice = 0;


            foreach ($request->products as $item) {
                $product = Product::find($item['product_id']);

                if ($product->quantity >= 5) {

                    if($product->quantity === 0){
                        return response()->json(['message' => 'Product out of stock.'], 400);
                    }

                }
                $quantity = $item['quantity'];
                $price = $product->price;
                $order->quantity =$quantity;
                $order->payment_method=$request->payment_method;
                $order->products()->attach($product->id, [
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $totalPrice += $quantity * $price;
            }

            $discountAmount = 0;


            if ($request->has('promo_code') && $request->promo_code) {
                $coupon = Coupon::where('promo_code', $request->promo_code)->active()->first();

                if ($coupon && $coupon->isValid()) {
                    if ($totalPrice >= $coupon->min_order_amount) {
                        if ($coupon->discount_type == 'percentage') {
                            $discountAmount = ($coupon->discount_value / 100) * $totalPrice;
                        } else if ($coupon->discount_type == 'fixed') {
                            $discountAmount = $coupon->discount_value;
                        }
                        $coupon->usage_limit -= 1;
                        $coupon->count += 1;
                        $coupon->save();
                    }
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid or expired promo code.',
                    ], 400);
                }
            }


            $order->total_price = $totalPrice - $discountAmount;
            $order->discount = $discountAmount;
            $order->save();




            $shipment = null;
            if ($request->name || $request->street_address || $request->city || $request->state_or_province) {
                $shipment = new Shipment();
                $shipment->order_id = $order->id;
                $shipment->tracking_number = "FEE_tracking_number" . $order->id;
                $shipment->carrier = $request->carrier ?? 'Default'; // Use a default carrier if none is provided
                $shipment->name = $request->name ?? '';
                $shipment->street_address = $request->street_address ?? '';
                $shipment->city = $request->city ?? '';
                $shipment->state_or_province = $request->state_or_province ?? '';
                $shipment->save();
            }
           if($request->payment_method==="credit_card"){

                $payment = new Payment();
                $payment->user_id = $user->id;
                $payment->order_id = $order->id;
                $payment->amount = $order->total_price;
                $payment->status = 'pending';
                $payment->payment_method = $request->payment_method;
                $payment->save();
                $myFatoorahController = new MyFatoorahController();
                return $myFatoorahController->index($order->id);

           } else{

            $order->on_cash=1;
            $order->save();
            return response()->json(
                [
                    'status'=>'success',
                    'message'=>'on cash payment order processed',
                    'data'=>$order
                ],200
            );

           }




        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function validatePromoCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'promo_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 422);
        }


        $coupon = Coupon::where('promo_code', $request->promo_code)->first();

        if (!$coupon) {
            return response()->json([
                'status' => 'error',
                'message' => 'Promo code does not exist.',
            ], 404);
        }


        if ($coupon->usage_limit <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Promo code has reached its usage limit.',
            ], 400);
        }

        if (!$coupon->active_status) {
            return response()->json([
                'status' => 'error',
                'message' => 'Promo code is not active.',
            ], 400);
        }

        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Promo code has expired.',
            ], 400);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Promo code is valid.',
            'discount_type' => $coupon->discount_type,
            'discount_value' => $coupon->discount_value,
            'min_order_amount' => $coupon->min_order_amount,
            'expires_at' => $coupon->expires_at ? $coupon->expires_at->format('Y-m-d H:i:s') : null,
        ], 200);
    }

    public function updateOrder(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'products' => 'required|array',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1',
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
            $order = Order::findOrFail($id);

            if ($order->user_id !== $user->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not authorized to update this order.',
                ], 403);
            }

            if ($order->status !== 'pending') {
                return response()->json(['message' => 'Only orders with pending status can be updated.'], 400);
            }

            $order->products()->detach();
            $totalPrice = 0;

            foreach ($request->products as $item) {
                $product = Product::find($item['product_id']);
                $quantity = $item['quantity'];
                $price = $product->price;

                $order->products()->attach($product->id, [
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $totalPrice += $quantity * $price;
            }

            $order->total_price = $totalPrice;
            $order->status = 'pending';
            $order->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Order updated successfully.',
                'order' => $order->load('products'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function getUserOrders(Request $request)
    {
        try {
            $user = Auth::user();
            $orders = Order::where('user_id',$user->id)->with('products')->get();

            return response()->json([
                'status' => 'success',
                'orders' => $orders,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteOrder(Request $request, $id)
    {
        try {

            $order = Order::findOrFail($id);


            if ($order->user_id !== Auth::id()) {
                return response()->json(['message' => 'Unauthorized. You do not have permission to delete this order.'], 403);
            }


            if ($order->status !== 'pending') {
                return response()->json(['message' => 'Only orders with pending status can be deleted.'], 400);
            }


            $order->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Order deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getOrder(Request $request, $id)
    {
        try {

            $order = Order::where('id', $id)
                ->where('user_id', Auth::id())
                ->with('products','payment','shipment')
                ->firstOrFail();

            return response()->json([
                'status' => 'success',
                'order' => $order,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function confirmOrder($id)
    {
        try {
            $order = Order::with('products','payment','shipment')->findOrFail($id);

            if ($order->user_id !== Auth::id()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }

            if ($order->status !== 'pending') {
                return response()->json(['message' => 'Order can only be confirmed if it is in pending status.'], 400);
            }

            $order->status = 'confirmed';
            $order->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Order confirmed successfully.',
                'order' => $order,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function completeCheckout($id)
    {
        try {
            $order = Order::with('payment','products')->findOrFail($id);

            if ($order->user_id !== Auth::id()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }

            if ($order->status !== 'confirmed') {
                return response()->json(['message' => 'Order can only be completed if it is in confirmed status.'], 400);
            }

            $order->status = 'completed';
            $order->save();


            $shipment = new Shipment();
            $shipment->order_id = $order->id;
            $shipment->tracking_number = 'TRK' . strtoupper(uniqid());
            $shipment->carrier = 'DHL';
            $shipment->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Checkout completed successfully and shipment created.',
                'order' => $order,
                'shipment' => $shipment,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
