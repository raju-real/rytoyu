<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function orderList()
    {
        $order = Order::query();
        $order->where('user_id',Auth::id());
        $order->when(request()->get('search'),function ($query) {
            $searchParam = request()->get('search');
            $query->where('invoice',"LIKE","%{$searchParam}%");
            $query->orWhere('mobile',"LIKE","%{$searchParam}%");
        });
        $orders = $order->latest()->paginate(3);
        return view('user.account.order_list',compact('orders'));
    }

    public function orderDetails($unique_id)
    {
        $order = Order::where('user_id',Auth::id())->where('unique_id',$unique_id)->firstOrFail();
        return view('user.account.order_details',compact('order'));
    }
}
