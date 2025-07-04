<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
        $orders = $data->paginate(10);
        return view('admin.orders.manage_orders', compact('orders'));
    }

    public function orderProducts($unique_id)
    {
        $order = Order::with([
            'order_products' => function ($oder_product) {
                $oder_product->orderBy('seller_id');
            }
        ])->whereUniqueId($unique_id)->firstOrFail();
        $html = view('admin.orders.order_products', compact('order'))->render();
        return response()->json([
            'title' => 'Order ' . $order->order_number . ' / ' . $order->invoice . ' Products',
            'html' => $html
        ]);
    }

    public function orderSummary($unique_id)
    {
        $order = Order::with(['order_products'])->whereUniqueId($unique_id)->firstOrFail();
        return view('admin.orders.order_summary', compact('order'));
    }

    public function commissionLogs()
    {
        $seller = request()->get('seller');
        $payment_status = request()->get('payment_status');
        $pay_to = request()->get('pay_to');

        $data = Order::query();
        $data->with([
            'seller_order_logs' => function ($log) use ($seller, $payment_status, $pay_to) {
                $log->with(['seller', 'seller.shop']);
                if ($seller) {
                    $log->where('seller_id', sellerIdByCode(request()->get('seller')));
                }
                if ($payment_status) {
                    $log->where('payment_status', request()->get('payment_status'));
                }
                if ($pay_to) {
                    $log->where('pay_to', request()->get('pay_to'));
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
        $data->select('id', 'unique_id', 'order_number', 'invoice', 'total_order_price', 'created_at');
        $orders = $data->paginate(20);
        return view('admin.orders.commission_logs', compact('orders'));
    }

    public function orderInvoice($unique_id)
    {
        $order = Order::with([
            'order_products' => function ($order_product) {
                $order_product->select('order_id', 'product_id', 'seller_id', 'item_order_price', 'quantity', 'item_total_order_price', 'size', 'color');
                $order_product->with([
                    'product' => function ($product) {
                        $product->select('id', 'product_code', 'name', 'thumbnail_path');
                    }
                ]);
            }
        ])->whereUniqueId($unique_id)->firstOrFail();
        //return view('pdf.order_invoice', compact('order'));
        $file = PDF::loadView('pdf.order_invoice', compact('order'));
        return $file->stream();
    }

    public function changeOrderStatus($unique_id = Null)
    {
        $order = Order::orderByUniqueId(($unique_id));
        return view('admin.orders.change_order_status', compact('order'));
    }

    public function updateOrderStatus()
    {
        $orderProduct = OrderProduct::find(request('id'));

        if (!$orderProduct) {
            return back()->with(dangerMessage('danger', 'Order product not found.'));
        }

        $transitions = [
            'pending' => ['processing', 'canceled'],
            'processing' => ['shipped'],
            'shipped' => ['delivered', 'returned'],
            'delivered' => [],
            'returned' => [],
        ];

        $currentStatus = $orderProduct->order_status;
        $allowedNextStatuses = $transitions[$currentStatus] ?? [];

        $validator = Validator::make(request()->all(), [
            'id' => ['required', 'exists:order_products,id'],
            'order_status' => [
                'required',
                Rule::in($allowedNextStatuses),
            ],
        ]);

        if ($validator->fails()) {
            return back()->with(dangerMessage('danger', 'Invalid order status transition.'));
        }

        if (authAdminType() === 'seller') {
            if ($orderProduct->seller_id !== Auth::id()) {
                return back()->with(dangerMessage('danger', 'Unauthorized action. This product does not belong to you.'));
            }
        }

        $validated = $validator->validated();

        $orderProduct->order_status = $validated['order_status'];
        $orderProduct->last_updated_by = Auth::id();
        $orderProduct->save();

        // Update order status by order product status ratio

        return back()->with(successMessage('success', 'Order product status updated to ' . ucfirst($validated['order_status']) . '.'));
    }

    public function updateOrderStatusAll()
    {
        $validator = Validator::make(request()->all(), [
            'unique_id' => ['required', 'exists:orders,unique_id'],
            'order_status' => 'required|in:canceled,processing,shipped',
        ]);

        if ($validator->fails()) {
            return back()->with(dangerMessage('danger', 'Invalid order status transition.'));
        }

        $order = Order::whereUniqueId(request()->get('unique_id'))->firstOrFail();
        OrderProduct::whereIn('order_id', [$order->id])->update([
            'order_status' => request()->get('order_status'),
            'last_updated_by' => Auth::id()
        ]);

        // Update order status by order product status ratio
        
        return back()->with(successMessage('success', 'All Order product status updated to ' . ucfirst(request()->get('order_status')) . '.'));
    }

}
