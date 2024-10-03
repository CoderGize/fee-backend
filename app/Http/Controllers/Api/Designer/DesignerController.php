<?php

namespace App\Http\Controllers\Api\Designer;

use App\Http\Controllers\Controller;
use App\Models\Designer;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignerController extends Controller
{

    public function index(Request $request)
    {
        try {

            $designerId = Auth::id();



            $last = $request->input('last', 7);
            $endDate = Carbon::now();
            $startDate = Carbon::now()->subDays($last);


            $totalOrders = Order::whereHas('products', function ($query) use ($designerId) {
                $query->where('designer_id', $designerId);
            })->count();


            $totalRevenue = Order::whereHas('products', function ($query) use ($designerId) {
                $query->where('designer_id', $designerId);
            })
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->sum('order_product.price');


            $totalProducts = Product::where('designer_id', $designerId)->count();


            $soldProducts = Order::whereHas('products', function ($query) use ($designerId) {
                $query->where('designer_id', $designerId);
            })->count();
            $salesRate = $totalProducts > 0 ? ($soldProducts / $totalProducts) : 0;


            $topOrders = Order::whereHas('products', function ($query) use ($designerId) {
                $query->where('designer_id', $designerId);
            })
            ->with(['products' => function ($query) use ($designerId) {
                $query->where('designer_id', $designerId);
            }, 'user'])
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->orderBy('order_product.quantity', 'desc')
            ->take(5)
            ->get();


            $productSalesSummary = Product::where('designer_id', $designerId)
                ->withCount(['orders' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('orders.created_at', [$startDate, $endDate]);
                }])
                ->get()
                ->map(function ($product) {
                    return [
                        'product_name' => $product->name,
                        'sales_count' => $product->orders_count,
                    ];
                });


            $salesData = Order::whereHas('products', function ($query) use ($designerId) {
                $query->where('designer_id', $designerId);
            })
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->selectRaw('DATE(orders.created_at) as date, SUM(order_product.price) as total_sales')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();


            $data = [
                'total_orders' => $totalOrders,
                'total_revenue' => $totalRevenue,
                'total_products' => $totalProducts,
                'sales_rate' => $salesRate,
                'top_orders' => $topOrders,
                'product_sales_summary' => $productSalesSummary,
                'sales_data_chart' => $salesData,
            ];

            return response()->json([
                'status' => 'success',
                'data' => $data,
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function orders(Request $request){
        try{
            $perPage = $request->per_page ? $request->per_page : 10;
            $designerId = Auth::id();


            $orders = Order::whereHas('products', function ($query) use ($designerId) {
                $query->where('designer_id', $designerId);
            })
            ->with(['products', 'user'])
            ->paginate($perPage);

            return response()->json([
                'status' => 'success',
                'orders' => $orders,
            ], 200);

        }
        catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


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
