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
        $createdAt = request()->get('created_at');
        if ($createdAt) {
            $data->whereDate('created_at', $createdAt);
        } else {
            $data->whereDate('created_at', now()->toDateString()); // Default to today
        }
        // You can now add more filters freely
        if (request()->has('status')) {
            $data->where('status', request()->get('status'));
        }
        if (request()->has('seller_id')) {
            $data->where('seller_id', request()->get('seller_id'));
        }
        $orders =  $data->paginate(20);
        return view('admin.orders.manage_orders',compact('orders'));
    }
}
