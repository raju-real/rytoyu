<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SellerOrderLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerOrderManageController extends Controller
{
    public function orderList()
    {
        $data = SellerOrderLog::query();
        $data->where('seller_id',Auth::id());
        if ($createdAt = request()->get('order_date')) {
            $data->whereDate('created_at', $createdAt);
        }

        if ($search = request()->get('search')) {
            $data->where(function ($query) use ($search) {
                $query->where('order_number', 'LIKE', "%{$search}%")
                    ->orWhere('invoice', 'LIKE', "%{$search}%");
            });
        }

        $orders =  $data->latest()->paginate(50);
        return view('seller.order_list', compact('orders'));
    }

    public function orderProducts($unique_id)
    {
        $order = Order::sellerOrderProduct($unique_id, Auth::id());
        $order_log = SellerOrderLog::where('order_id', orderIdByUniqueId($unique_id))->where('seller_id', Auth::id())->first();
        $html = view('seller.order_products', compact('order', 'order_log'))->render();
        return response()->json([
            'title' => 'Order ' . $order->order_number . ' / ' . $order->invoice . ' Products',
            'html' => $html
        ]);
    }
}
