<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class NagadService
{
    private $merchant_id;
    private $merchant_number;
    private $public_key;
    private $private_key;
    private $mode;

    public function __construct()
    {
        $settings = paymentSettings();
        $this->merchant_id = $settings['nagad_merchant_id'] ?? '';
        $this->merchant_number = $settings['nagad_merchant_number'] ?? '';
        $this->public_key = $settings['nagad_public_key'] ?? '';
        $this->private_key = $settings['nagad_private_key'] ?? '';
        $this->mode = $settings['nagad_mode'] ?? 'sandbox';
    }

    public function index($request)
    {
        $unique_id = $request->unique_id;
        $order = Order::whereUniqueId($unique_id)->first();

        // Placeholder for Nagad payment initialization
        return redirect()->route('order-list')->with([
            'type' => 'info',
            'message' => 'Nagad Gateway Integration is in progress. Simulated checkout.'
        ]);
    }
}
