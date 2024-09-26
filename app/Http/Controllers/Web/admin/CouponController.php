<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    public function index(Request $request)
    {
       $search = $request->input('search');
       $perPage = $request->input('per_page', 10);
       $status = $request->input('status');

       $query = Coupon::query();


       if ($search) {
           $query->where('name', 'like', '%' . $search . '%')
               ->orWhere('promo_code', 'like', '%' . $search . '%');

       }
       if ($status === 'expired') {
            $query->where('expires_at', '<', now());
        } elseif ($status === 'not_expired') {
            $query->where(function ($q) {
                $q->where('expires_at', '>=', now())
                ->orWhereNull('expires_at'); 
            });
        }

        $coupons = $query->paginate($perPage);

        return view('admin.coupons.index',compact('coupons'));
    }
    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'promo_code' => 'required|string|max:255|unique:coupons',
            'discount_type' => 'required|string',
            'discount_value' => 'required|numeric',
            'min_order_amount' => 'nullable|numeric',
            'usage_limit' => 'nullable|integer',
            'expires_at' => 'nullable|date',
        ]);

        Coupon::create($request->all());


        return redirect()->route('admin.coupons.index')->with('message', 'Coupon created successfully!');
    }

    public function edit($id)
    {
        $coupon=Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'promo_code' => 'required|string|max:255|unique:coupons,promo_code,' . $id,
            'discount_type' => 'required|string',
            'discount_value' => 'required|numeric',
            'min_order_amount' => 'nullable|numeric',
            'usage_limit' => 'nullable|integer',
            'expires_at' => 'nullable|date',
        ]);
        $coupon=Coupon::findOrFail($id);

        $coupon->update($request->all());

        return redirect()->route('admin.coupons.index')->with('message', 'Coupon updated successfully!');
    }

    public function destroy($id)
    {
        $coupon=Coupon::findOrFail($id);
        $coupon->delete();


        return redirect()->route('admin.coupons.index')->with('message', 'Coupon deleted successfully!');
    }


    public function disable($id)
    {
        $coupon=Coupon::findOrFail($id);
        $coupon->update(['active_status' => false]);



        return redirect()->route('admin.coupons.index')->with('message', 'Coupon disabled successfully!');
    }

    public function enable($id)
    {
        $coupon=Coupon::findOrFail($id);
        $coupon->update(['active_status' => true]);


        return redirect()->route('admin.coupons.index')->with('message', 'Coupon enabled successfully!');
    }
}
