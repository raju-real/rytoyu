<?php

// app/Jobs/LogSellerOrderJob.php

namespace App\Jobs;

use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Bus\Queueable;
use App\Models\SellerOrderLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class LogSellerOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function handle()
    {
        $order = Order::find($this->orderId);
        if (!$order) return; // Return for false order
        // Process log
        $sellerIds = OrderProduct::where('order_id', $order->id)
            ->distinct()
            ->pluck('seller_id');
        foreach ($sellerIds as $sellerId) {
            $totalProduct = OrderProduct::where('order_id', $order->id)
                ->where('seller_id', $sellerId)
                ->count();

            $orderAmount = OrderProduct::where('order_id', $order->id)
                ->where('seller_id', $sellerId)
                ->sum('item_total_order_price') ?? 0;
            // Fetch seller's commission rate from Admin model
            $seller = Admin::find($sellerId); // Ensure your Admin model is namespaced correctly
            $commissionRate = $seller->commission_rate ?? 0;
            // Calculate commission (as a percentage of the order amount)
            $commission = ($orderAmount * $commissionRate) / 100;
            // Create the log entry
            SellerOrderLog::create([
                'seller_id' => $sellerId,
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'invoice' => $order->invoice,
                'total_product' => $totalProduct,
                'order_amount' => $orderAmount,
                'commission_rate' => $commissionRate,
                'total_commission' => $commission,
                'payment_status' => 'unpaid'
            ]);
        }

        // Save qr code
        $qr_data =
            "Order Details\n" .
            "-----------------------\n" .
            "Order No: " . $order->order_number . "\n" .
            "Invoice No: " . $order->invoice . "\n" .
            "Order Date: " . $order->created_at->format('d M, Y') . "\n" .
            "Customer: " . $order->customer_full_name . "\n" .
            "Mobile: " . $order->mobile . "\n" .
            "City: " . $order->city_town . "\n" .
            "Post Code: " . $order->post_code . "\n" .
            "Address: " . $order->address . "\n" .
            "Total Amount: " . number_format($order->total_order_price, 2) . " BDT";

        generateQr($qr_data, 'order_' . $order->order_number, 200, 0); // if not saved do it on order model

        // Send notification to customer
        // Send notification to seller
        // Send notification admin
    }
}
