<?php

namespace App\Http\Controllers\Api\Designer;

use App\Http\Controllers\Controller;
use App\Models\Designer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignerController extends Controller
{
    public function getSoldProducts(Request $request)
    {
        try {
            $designer = Auth::user();

            $soldProducts = Order::whereHas('products', function ($query) use ($designer) {
                $query->where('designer_id', $designer->id);
            })->with(['products' => function ($query) use ($designer) {
                $query->where('designer_id', $designer->id);
            }])->get();

            return response()->json([
                'status' => 'success',
                'sold_products' => $soldProducts,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $designers = Designer::where('f_name', 'LIKE', "%{$query}%")
                            ->orWhere('l_name', 'LIKE', "%{$query}%")
                            ->get();

        return response()->json([
            'status' => 'success',
            'designers' => $designers,
        ]);
    }

}
