<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');
        $status = $request->input('status');
        $status_shipment = $request->input('status_shipment');
        $paymentMethod = $request->input('payment_method');
        $perPage = $request->input('per_page', 10);


        $orders = Order::where('is_guest',0)
                       ->with(['user', 'designer','products','shipment'])
                        ->when($search, function ($query, $search) {
                            return $query->whereHas('user', function ($q) use ($search) {
                                $q->where('f_name', 'like', '%' . $search . '%');
                            });
                        })
                        ->when($search, function ($query, $search) {
                            return $query->whereHas('designer', function ($q) use ($search) {
                                $q->where('f_name', 'like', '%' . $search . '%');
                            });
                        })
                        ->when($status_shipment, function ($query, $status_shipment) {
                            return $query->whereHas('shipment', function ($q) use ($status_shipment) {
                                $q->where('delivery_status', $status_shipment);
                            });
                        })
                        ->when($status, function ($query, $status) {
                            return $query->where('status', $status);
                        })
                        ->when($paymentMethod, function ($query, $paymentMethod) {
                            return $query->where('payment_method', $paymentMethod);
                        })
                        ->when($search, function ($query, $search) {
                            return $query->where('f_name', $search)
                                        ->orWhere('order_email', $search);
                        })
                        ->paginate($perPage);

        return view('admin.orders.index', compact('orders'));
    }
    public function guest(Request $request)
    {

        $search = $request->input('search');
        $status = $request->input('status');
        $paymentMethod = $request->input('payment_method');
        $perPage = $request->input('per_page', 10);
        $status_shipment = $request->input('status_shipment');


        $orders = Order::where('is_guest',1)
                    ->with('products','shipment')
                    ->when($search, function ($query, $search) {
                        return $query->where('guest_name', 'like', '%' . $search . '%')
                                    ->orWhere('guest_l_name', 'like', '%' . $search . '%')
                                    ->orWhere('guest_email', 'like', '%' . $search . '%')
                                    ->orWhere('guest_phone', 'like', '%' . $search . '%');
                    })
                    ->when($status, function ($query, $status) {
                        return $query->where('status', $status);
                    })
                    ->when($status_shipment, function ($query, $status_shipment) {
                        return $query->whereHas('shipment', function ($q) use ($status_shipment) {
                            $q->where('delivery_status', $status_shipment);
                        });
                    })
                    ->when($paymentMethod, function ($query, $paymentMethod) {
                        return $query->where('payment_method', $paymentMethod);
                    })
                    ->paginate($perPage);

        return view('admin.orders.guest', compact('orders'));
    }
    public function updateStatus(Request $request, $id)
    {

        $order = Order::findOrFail($id);


        $order->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->back()->with('message', 'Order status updated successfully.');
    }

    public function updateShipmentStatus(Request $request, $id)
    {

        $shipment = Shipment::where('order_id',$id)->first();


        $shipment->update([
            'delivery_status' => $request->input('status'),
        ]);

        return redirect()->back()->with('message', 'shipment status updated successfully.');
    }
}
