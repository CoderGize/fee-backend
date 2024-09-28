<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');
        $status = $request->input('status');
        $paymentMethod = $request->input('payment_method');
        $perPage = $request->input('per_page', 10);

        $payments = Payment::where('is_guest',0)
                ->with(['user', 'designer','order'])
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


        return view('admin.payments.index', compact('payments'));
    }

    public function guest(Request $request)
    {

        $search = $request->input('search');
        $status = $request->input('status');
        $paymentMethod = $request->input('payment_method');
        $perPage = $request->input('per_page', 10);

        $payments = Payment::where('is_guest',1)
                ->with('order')
                ->when($search, function ($query, $search) {
                    return $query->where('guest_name', 'like', '%' . $search . '%')
                                ->orWhere('guest_email', 'like', '%' . $search . '%')
                                ->orWhere('guest_phone', 'like', '%' . $search . '%');
                })
                ->when($status, function ($query, $status) {
                    return $query->where('status', $status);
                })
                ->when($paymentMethod, function ($query, $paymentMethod) {
                    return $query->where('payment_method', $paymentMethod);
                })
                ->paginate($perPage);


        return view('admin.payments.guest', compact('payments'));
    }

    public function updateStatus(Request $request, $id)
    {

        $payment = Payment::findOrFail($id);


        $payment->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->back()->with('message', 'Payment status updated successfully.');
    }
}
