<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class OrderController extends Controller
{
    public function orderList()
    {
        $order = Order::query();
        $order->where('user_id', Auth::id());
        $order->when(request()->get('search'), function ($query) {
            $searchParam = request()->get('search');
            $query->where('invoice', "LIKE", "%{$searchParam}%");
            $query->orWhere('mobile', "LIKE", "%{$searchParam}%");
        });
        $orders = $order->latest()->paginate(3);
        return view('user.account.order_list', compact('orders'));
    }

    public function orderDetails($unique_id)
    {
        $order = Order::where('user_id', Auth::id())->where('unique_id', $unique_id)->firstOrFail();
        return view('user.account.order_details', compact('order'));
    }

    public function orderInvoice($unique_id)
    {
        $order = Order::orderByUniqueId($unique_id);
        $file = PDF::loadView('pdf.order_invoice', compact('order'));
        return $file->stream();
    }

    public function submitReview($combine_id)
    {
        $parts = explode('-', $combine_id);
        $order_product_id = $parts[1];
        $order_product = OrderProduct::where('id',$order_product_id)->where("user_id",Auth::id())->where('order_status','delivered')->firstOrFail();
    }
}
