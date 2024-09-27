<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');
        $status = $request->input('status');
        $paymentMethod = $request->input('payment_method');
        $perPage = $request->input('per_page', 10);


        $orders = Order::with(['user', 'designer','products'])
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
                        ->when($status, function ($query, $status) {
                            return $query->where('status', $status);
                        })
                        ->when($paymentMethod, function ($query, $paymentMethod) {
                            return $query->where('payment_method', $paymentMethod);
                        })
                        ->paginate($perPage);

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {

        $order = Order::findOrFail($id);


        $order->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->back()->with('message', 'Order status updated successfully.');
    }
}
