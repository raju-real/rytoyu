<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorPayout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PayoutController extends Controller
{
    public function index()
    {
        $seller = Auth::guard('admin')->user();
        $payouts = VendorPayout::where('seller_id', $seller->id)->latest()->get();
        return view('admin.seller_payouts.index', compact('payouts', 'seller'));
    }

    public function requestPayout(Request $request)
    {
        $seller = Auth::guard('admin')->user();

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:100|max:' . $seller->balance,
            'transaction_method' => 'required|string',
            'instructions' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check for pending payouts
        $pendingPayout = VendorPayout::where('seller_id', $seller->id)
            ->where('status', 'pending')
            ->exists();

        if ($pendingPayout) {
            return redirect()->back()->with([
                'type' => 'error',
                'message' => 'You already have a pending payout request. Please wait for it to be processed.'
            ]);
        }

        VendorPayout::create([
            'seller_id' => $seller->id,
            'amount' => $request->amount,
            'transaction_method' => $request->transaction_method,
            'instructions' => $request->instructions,
        ]);

        return redirect()->back()->with([
            'type' => 'success',
            'message' => 'Payout request submitted successfully.'
        ]);
    }
}
