<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            do {
                $uuid = Str::upper(Str::random(10)); // 10-char uppercase string
            } while (Order::where('unique_id', $uuid)->exists());
            $order->unique_id = $uuid;
        });
    }

    protected $appends = ['customer_full_name', 'seller_count',  'payment_method_name', 'qr_image_path'];

    public function getCustomerFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getSellerCountAttribute()
    {
        return SellerOrderLog::where('order_id', $this->id)->distinct()->count('seller_id') ?? 0;
    }

    public function getQrImagePathAttribute()
    {
        return 'assets/files/qr_images/order_' . $this->order_number . '.png';
    }

    public function getPaymentMethodNameAttribute()
    {
        if ($this->payment_method === 'cash-on-delivery') {
            return 'Cash on Delivery';
        } elseif ($this->payment_method === 'online-payment') {
            return 'Online Payment';
        } else {
            return 'Unknown';
        }
    }

    public static function getOrderNumber(): string
    {
        $latestOrderNumber = Order::latest('id')->first();
        $newOrderNumber = str_pad(1, 4, "0", STR_PAD_LEFT);
        if ($latestOrderNumber) {
            $lastOrderNumber = $latestOrderNumber->order_number;
            if ($lastOrderNumber != null) {
                $newSerialNumber = $lastOrderNumber + 1;
                $newOrderNumber = str_pad($newSerialNumber, 4, "0", STR_PAD_LEFT);;
            } else {
                $newOrderNumber = str_pad(1, 4, "0", STR_PAD_LEFT);
            }
        }
        if (Order::where('order_number', $newOrderNumber)->exists()) {
            Order::getOrderNumber();
        }
        return $newOrderNumber;
    }

    public static function getInvoiceNumber(): string
    {
        $orderInvoice = "RT-" . mt_rand(10000000, 99999999);
        if (Order::where('invoice', $orderInvoice)->exists()) {
            Order::getInvoiceNumber();
        }
        return $orderInvoice;
    }

    public static function getTotalItemUnitPrice($cartItems)
    {
        $total = 0;
        foreach ($cartItems['items'] as $item) {
            $variant_id = $item['variant_id'];
            $variant = ProductVariant::find($variant_id);
            if (!$variant) {
                return 0;
            }
            $price = $variant->unit_price;
            $quantity = $item['quantity'] ?? 1;
            $total += $price * $quantity;
        }
        return $total;
    }

    public static function getTotalItemDiscountPrice($cartItems)
    {
        $total = 0;
        foreach ($cartItems['items'] as $item) {
            $variant_id = $item['variant_id'];
            $variant = ProductVariant::find($variant_id);
            if (!$variant) {
                return 0;
            }
            $price = $variant->unit_price - $variant->discount_price;
            $quantity = $item['quantity'] ?? 1;
            $total += $price * $quantity;
        }
        return $total;
    }

    public static function getItemOrderPrice($cartItems)
    {
        $total = 0;
        foreach ($cartItems['items'] as $item) {
            $variant_id = $item['variant_id'];
            $variant = ProductVariant::find($variant_id);
            if (!$variant) {
                return 0;
            }
            $price = $variant->discount_price > 0 ? $variant->discount_price : $variant->unit_price;
            $quantity = $item['quantity'] ?? 1;
            $total += $price * $quantity;
        }
        return $total;
    }

    public function order_products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function seller_order_logs()
    {
        return $this->hasMany(SellerOrderLog::class, 'order_id', 'id');
    }

    public function transaction() {
        return $this->hasOne(Transaction::class,'order_id','id');
    }

    public function district() {
        return $this->belongsTo(DeliveryCharge::class,'district_id','id');
    }
}
