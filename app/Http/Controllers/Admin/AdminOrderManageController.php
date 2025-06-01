<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

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
        $data->latest();
        $orders =  $data->paginate(10);
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
            'title' => 'Order ' . $order->order_number . ' / ' . $order->invoice . ' Products',
            'html' => $html
        ]);
    }

    public function orderSummary($unique_id) {
        $order = Order::whereUniqueId($unique_id)->firstOrFail();
        return view('admin.orders.order_summary',compact('order'));
    }

    public function commissionLogs()
    {
        $seller = request()->get('seller');
        $payment_status = request()->get('payment_status');
        $pay_to = request()->get('pay_to');

        $data = Order::query();
        $data->with([
            'seller_order_logs' => function($log) use($seller,$payment_status,$pay_to) {
                $log->with(['seller','seller.shop']);
                if($seller) {
                    $log->where('seller_id',sellerIdByCode(request()->get('seller')));
                }
                if($payment_status) {
                    $log->where('payment_status',request()->get('payment_status'));
                }
                if($pay_to) {
                    $log->where('pay_to',request()->get('pay_to'));
                }
            }
        ]);
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
        $data->select('id','unique_id','order_number','invoice','total_order_price','created_at');
        $orders =  $data->paginate(20);
        return view('admin.orders.commission_logs', compact('orders'));
    }

    public function orderInvoice($unique_id) {
        $order = Order::with([
            'order_products' => function($order_product) {
                $order_product->select('order_id','product_id','seller_id','item_order_price','quantity','item_total_order_price','size','color');
                $order_product->with([
                    'product' => function($product) {
                        $product->select('id','product_code','name','thumbnail_path');
                    }
                ]);
            }
        ])->whereUniqueId($unique_id)->firstOrFail();
        //return view('pdf.order_invoice', compact('order'));
        $file = PDF::loadView('pdf.order_invoice', compact('order'));
        return $file->stream();
    }
}
