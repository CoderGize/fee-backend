<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {

        $orders = Order::with(['user', 'products'])->paginate(10);


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
