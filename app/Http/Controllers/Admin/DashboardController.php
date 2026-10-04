<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\SellerOrderLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        if (authAdminType() === 'administrator') {
            $totalOrders = Order::count();
            $totalRevenue = Order::where('payment_status', 'paid')->sum('total_order_price');
            $totalProducts = Product::count();
            $averagePrice = Order::where('payment_status', 'paid')->avg('total_order_price') ?? 0;
            $latestOrders = Order::latest()->take(10)->get();
        } else {
            $sellerId = authSellerId();
            $totalOrders = SellerOrderLog::where('seller_id', $sellerId)->count();
            $totalRevenue = SellerOrderLog::where('seller_id', $sellerId)->sum('seller_amount');
            $totalProducts = Product::where('seller_id', $sellerId)->count();
            $averagePrice = SellerOrderLog::where('seller_id', $sellerId)->avg('seller_amount') ?? 0;
            $latestOrders = SellerOrderLog::where('seller_id', $sellerId)->latest()->take(10)->get();
        }

        return view('admin.dashboard', compact('totalOrders', 'totalRevenue', 'totalProducts', 'averagePrice', 'latestOrders'));
    }

    public function getMonthlySalesData(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $labels = [];
        $data = [];

        // Initialize all days of the month with 0 using a 1-indexed array map
        $dailySales = array_fill(1, $daysInMonth, 0);

        if (authAdminType() === 'administrator') {
            $sales = Order::where('payment_status', 'paid')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->select(DB::raw('DAY(created_at) as day'), DB::raw('SUM(total_order_price) as total_sales'))
                ->groupBy('day')
                ->get();
        } else {
            $sellerId = authSellerId();
            $sales = SellerOrderLog::where('seller_id', $sellerId)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->select(DB::raw('DAY(created_at) as day'), DB::raw('SUM(seller_amount) as total_sales'))
                ->groupBy('day')
                ->get();
        }

        foreach ($sales as $sale) {
            $dailySales[$sale->day] = $sale->total_sales;
        }

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $labels[] = str_pad($i, 2, '0', STR_PAD_LEFT) . '-' . date('M', mktime(0, 0, 0, $month, 10)); // e.g. 01-Jan
            $data[] = round($dailySales[$i], 2);
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}
