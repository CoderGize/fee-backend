<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Designer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dash(Request $request)
    {

        $totalDesigners=Designer::count();
        $totalUsers=User::count();
        $totalOrders = Order::count();


        $totalRevenue = Order::where('status','paid')->sum('total_price');


        $totalProducts = Product::count();


        $totalSoldProducts = Order::where('status','paid')->sum('quantity');
        $salesRate = ($totalProducts > 0) ? ($totalSoldProducts / $totalProducts) * 100 : 0;


        $topCustomers = User::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();


        $productSales = Product::with('orders')
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->name,
                    'sales' => $product->orders()->sum('order_product.quantity')
                ];
            });


        $startDate = $request->has('start_date') ? $request->start_date : Carbon::now()->subDays(30);
        $endDate = $request->has('end_date') ? $request->end_date : Carbon::now();

        $salesData = Order::where('status', 'paid')->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as total_sales')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

         return view('admin.home', compact(
             'totalOrders', 'totalRevenue', 'totalProducts', 'salesRate', 'topCustomers',
             'productSales', 'totalDesigners', 'totalUsers', 'salesData'
         ));
    }
}
