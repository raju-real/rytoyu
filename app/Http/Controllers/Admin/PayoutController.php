<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorPayout;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class PayoutController extends Controller
{
    public function index()
    {
        $payouts = VendorPayout::with('seller')->latest()->get();
        return view('admin.payouts.index', compact('payouts'));
    }

    public function processPayout(Request $request, $id)
    {
        $payout = VendorPayout::findOrFail($id);

        if ($payout->status !== 'pending') {
            return redirect()->back()->with([
                'type' => 'error',
                'message' => 'This payout request has already been processed.'
            ]);
        }

        $seller = Admin::findOrFail($payout->seller_id);
        $status = $request->input('status');

        if ($status === 'approved') {
            if ($seller->balance < $payout->amount) {
                return redirect()->back()->with([
                    'type' => 'error',
                    'message' => 'Seller balance is lower than the requested amount.'
                ]);
            }
            // Deduct balance
            $seller->balance -= $payout->amount;
            $seller->save();
        }

        $payout->update([
            'status' => $status,
            'admin_id' => Auth::guard('admin')->user()->id
        ]);

        $msg = $status === 'approved' ? 'Payout approved successfully.' : 'Payout rejected.';
        return redirect()->back()->with([
            'type' => 'success',
            'message' => $msg
        ]);
    }
}
