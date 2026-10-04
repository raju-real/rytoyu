<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BkashService
{
    private $app_key;
    private $app_secret;
    private $username;
    private $password;
    private $mode;

    public function __construct()
    {
        $settings = paymentSettings();
        $this->app_key = $settings['bkash_app_key'] ?? '';
        $this->app_secret = $settings['bkash_app_secret'] ?? '';
        $this->username = $settings['bkash_username'] ?? '';
        $this->password = $settings['bkash_password'] ?? '';
        $this->mode = $settings['bkash_mode'] ?? 'sandbox';
    }

    public function index($request)
    {
        $unique_id = $request->unique_id;
        $order = Order::whereUniqueId($unique_id)->first();

        // This is a placeholder for bKash initialization
        // Usually you call bKash Create Payment API here and redirect

        return redirect()->route('order-list')->with([
            'type' => 'info',
            'message' => 'bKash Gateway Integration is in progress. Simulated checkout.'
        ]);
    }
}
