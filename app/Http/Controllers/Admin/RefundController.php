<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RefundRequest;
use Illuminate\Support\Facades\Auth;

class RefundController extends Controller
{
    public function index()
    {
        $refunds = RefundRequest::with(['user', 'orderProduct.product'])->latest()->get();
        return view('admin.refunds.index', compact('refunds'));
    }

    public function processRefund(Request $request, $id)
    {
        $refund = RefundRequest::findOrFail($id);

        if ($refund->status === 'completed' || $refund->status === 'rejected') {
            return redirect()->back()->with(['type' => 'error', 'message' => 'This request has already been processed.']);
        }

        $status = $request->input('status');

        $refund->update([
            'status' => $status,
            'admin_note' => $request->input('admin_note'),
            'admin_id' => Auth::guard('admin')->user()->id
        ]);

        // If approved/completed, we would trigger the actual gateway refund here or adjust user wallet/balance.
        // For now, marking it in the system is sufficient to track the request workflow.

        return redirect()->back()->with(['type' => 'success', 'message' => 'Refund request marked as ' . $status . '.']);
    }
}
