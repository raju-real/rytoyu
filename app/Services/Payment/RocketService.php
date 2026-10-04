<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class RocketService
{
    private $merchant_account;
    private $mode;

    public function __construct()
    {
        $settings = paymentSettings();
        $this->merchant_account = $settings['rocket_merchant_account'] ?? '';
        $this->mode = $settings['rocket_mode'] ?? 'sandbox';
    }

    public function index($request)
    {
        $unique_id = $request->unique_id;
        $order = Order::whereUniqueId($unique_id)->first();

        // Placeholder for Rocket payment initialization
        return redirect()->route('order-list')->with([
            'type' => 'info',
            'message' => 'Rocket Gateway Integration is in progress. Simulated checkout.'
        ]);
    }
}
