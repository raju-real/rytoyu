<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\SellerOrderLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class SellerOrderManageController extends Controller
{
    public function orderList()
    {
        $data = SellerOrderLog::query();
        $data->where('seller_id', Auth::id());
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

    public function orderInvoice($unique_id)
    {
        $order = Order::sellerOrderProduct($unique_id, Auth::id());
        $order_log = SellerOrderLog::where('order_id', orderIdByUniqueId($unique_id))->where('seller_id', Auth::id())->first();
        $file = PDF::loadView('pdf.seller_order_invoice', compact('order', 'order_log'));
        return $file->stream();
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

    public function changeOrderStatus($unique_id = Null)
    {
        $order = Order::sellerOrderProduct($unique_id, Auth::id());
        return view('seller.change_order_status', compact('order'));
    }

    public function updateOrderStatus()
    {
        $order_product_id = encrypt_decrypt(request('id'), 'decrypt');
        $orderProduct = OrderProduct::where('id', $order_product_id)->where('seller_id', Auth::id())->firstOrFail();

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

        // Increment seller balance if delivered
        if ($validated['order_status'] === 'delivered' && $orderProduct->seller_id) {
            $sellerAdmin = clone Auth::guard('admin')->user();
            if ($sellerAdmin->id === $orderProduct->seller_id) {
                // Calculate total to add (price * qty) - maybe deduct commission later? (Simplified for now)
                $amount_to_add = $orderProduct->total_price;

                // If there's commission logic, it should go here. Assuming total_price is what the seller gets for now.
                $sellerAdmin->balance += $amount_to_add;
                $sellerAdmin->save();
            }
        }

        return back()->with(successMessage('success', 'Order product status updated to ' . ucfirst($validated['order_status']) . '.'));
    }

    public function updateOrderStatusAll()
    {
        $validator = Validator::make(request()->all(), [
            'unique_id' => ['required', 'exists:orders,unique_id'],
            'order_status' => 'required|in:canceled,processing,shipped,delivered',
        ]);
        if ($validator->fails()) {
            return back()->with(dangerMessage('danger', 'Invalid order status transition.'));
        }
        $order = Order::whereUniqueId(request()->get('unique_id'))->firstOrFail();

        $orderProducts = OrderProduct::whereIn('order_id', [$order->id])->where('seller_id', Auth::id())->get();

        foreach ($orderProducts as $op) {
            if ($op->order_status !== request()->get('order_status')) {
                $op->order_status = request()->get('order_status');
                $op->last_updated_by = Auth::id();
                $op->save();

                if (request()->get('order_status') === 'delivered') {
                    $sellerAdmin = Auth::guard('admin')->user();
                    $sellerAdmin->balance += $op->total_price;
                    $sellerAdmin->save();
                }
            }
        }

        return back()->with(successMessage('success', 'All Order product status updated to ' . ucfirst(request()->get('order_status')) . '.'));
    }
}
