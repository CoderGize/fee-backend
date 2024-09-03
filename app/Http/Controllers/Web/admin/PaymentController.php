<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {

        $payments = Payment::with(['user', 'order'])->paginate(10);


        return view('admin.payments.index', compact('payments'));
    }

    public function updateStatus(Request $request, $id)
    {

        $payment = Payment::findOrFail($id);


        $payment->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->back()->with('success', 'Payment status updated successfully.');
    }
}
