<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderManageController extends Controller
{
    public function manageOrders()
    {
        $data = Order::query();
        $createdAt = request()->get('order_date');
        if ($createdAt) {
            $data->whereDate('created_at', $createdAt);
        } 
        if ($search = request()->get('search')) {
            $data->where(function ($query) use ($search) {
                $query->where('order_number', 'LIKE', "%{$search}%")
                    ->orWhere('invoice', 'LIKE', "%{$search}%")
                    ->orWhere('mobile', 'LIKE', "%{$search}%");
            });
        }
        $orders =  $data->paginate(20);
        return view('admin.orders.manage_orders', compact('orders'));
    }

    public function orderProducts($unique_id)
    {
        $order = Order::with([
            'order_products' => function ($oder_product) {
                $oder_product->orderBy('seller_id');
            }
        ])->whereUniqueId($unique_id)->firstOrFail();
        $html =  view('admin.orders.order_products', compact('order'))->render();
        return response()->json([
            'title' => 'Order ' . $order->order_number . ' Products',
            'html' => $html
        ]);
    }
}
