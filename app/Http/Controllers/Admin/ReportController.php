<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\SellerOrderLog;

class ReportController extends Controller
{
    public function salesReport(Request $request)
    {
        $query = Order::query();
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
        }

        $totalSales = $query->sum('total_order_price');
        $totalOrders = $query->count();
        $orders = $query->orderBy('id', 'desc')->paginate(20);

        return view('admin.reports.sales', compact('orders', 'totalSales', 'totalOrders'));
    }

    public function commissionReport(Request $request)
    {
        $query = SellerOrderLog::query();
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
        }

        $totalAdminCommission = $query->sum('total_commission');
        $totalSellerPayouts = $query->sum('seller_amount');
        $logs = $query->with('seller')->orderBy('id', 'desc')->paginate(20);

        return view('admin.reports.commission', compact('logs', 'totalAdminCommission', 'totalSellerPayouts'));
    }
}
