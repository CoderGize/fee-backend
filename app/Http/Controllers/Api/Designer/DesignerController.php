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
        try {

            $query = $request->input('query', '');
            $search = $request->input('search', '');


            if (!empty($query)) {

                $designers = Designer::whereRaw("LOWER(f_name) LIKE LOWER(?)", [$query . '%'])
                    ->orderBy('f_name', 'asc')
                    ->orderBy('l_name', 'asc')
                    ->get();
            }

            elseif (!empty($search)) {
                $designers = Designer::whereRaw("LOWER(f_name) LIKE LOWER(?)", ['%' . $search . '%'])
                    ->orWhereRaw("LOWER(l_name) LIKE LOWER(?)", ['%' . $search . '%'])
                    ->orderBy('f_name', 'asc')
                    ->orderBy('l_name', 'asc')
                    ->get();
            }

            else {
                $designers = Designer::orderBy('f_name', 'asc')
                    ->orderBy('l_name', 'asc')
                    ->get();
            }


            return response()->json([
                'status' => 'success',
                'designers' => $designers->isEmpty() ? [] : $designers,
            ]);

        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
