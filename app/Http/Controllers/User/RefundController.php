<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RefundRequest;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RefundController extends Controller
{
    public function index()
    {
        $refunds = RefundRequest::with('orderProduct.product')->where('user_id', Auth::id())->latest()->get();
        return view('user.account.refunds', compact('refunds'));
    }

    public function requestRefund(Request $request, $order_product_id)
    {
        $orderProduct = OrderProduct::findOrFail($order_product_id);

        if ($orderProduct->order->user_id !== Auth::id()) {
            return redirect()->back()->with(['type' => 'error', 'message' => 'Unauthorized action.']);
        }

        // Check if already requested
        $existing = RefundRequest::where('order_product_id', $order_product_id)->first();
        if ($existing) {
            return redirect()->back()->with(['type' => 'error', 'message' => 'A refund request already exists for this item.']);
        }

        // Only delivered items can be refunded
        if ($orderProduct->order_status !== 'delivered') {
            return redirect()->back()->with(['type' => 'error', 'message' => 'You can only request a refund for delivered items.']);
        }

        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        RefundRequest::create([
            'user_id' => Auth::id(),
            'order_id' => $orderProduct->order_id,
            'order_product_id' => $order_product_id,
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        return redirect()->back()->with(['type' => 'success', 'message' => 'Refund request submitted successfully.']);
    }
}
