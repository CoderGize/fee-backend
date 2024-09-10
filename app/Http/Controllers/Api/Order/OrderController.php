<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MyFatoorahController;
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
            'shipment' => 'nullable|array',
            'shipment.tracking_number' => 'nullable|string',
            'shipment.carrier' => 'nullable|string',
            'shipment.name' => 'nullable|string',
            'shipment.street_address' => 'nullable|string',
            'shipment.city' => 'nullable|string',
            'shipment.state_or_province' => 'nullable|string',
            'shipment.paid_status' => 'nullable|string',
            'shipment.delivery_status' => 'nullable|string',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'products'=>$request->products ,
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
            $quantity = $item['quantity'];
            $price = $product->price;

            $order->products()->attach($product->id, [
                'quantity' => $quantity,
                'price' => $price,
            ]);

            $totalPrice += $quantity * $price;
        }

        $discountAmount = ($order->discount / 100) * $totalPrice;
        $order->total_price = $totalPrice - $discountAmount;
        $order->save();


        // Create Payment
        $payment = new Payment();
        $payment->user_id = $user->id;
        $payment->order_id = $order->id;
        $payment->amount = $order->total_price;
        $payment->status = 'pending';
        $payment->payment_method = $request->payment_method;
        $payment->save();

        $tracking_number="FEE_tracking_number".$order->id;

        $shipment = new Shipment();
        $shipment->order_id = $order->id;
        $shipment->tracking_number = $tracking_number;
        $shipment->carrier = "Default";
        $shipment->name = $request->shipment['name'];
        $shipment->street_address = $request->shipment['street_address'];
        $shipment->city = $request->shipment['city'];
        $shipment->state_or_province = $request->shipment['state_or_province'];
        $shipment->paid_status = $request->shipment['paid_status'];
        $shipment->delivery_status = $request->shipment['delivery_status'];
        $shipment->save();


        $myFatoorahController = new MyFatoorahController();
        return $myFatoorahController->index($order->id);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
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
