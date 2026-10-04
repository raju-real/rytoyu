<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'type',
        'title',
        'message',
        'url',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // ── Scopes ────────────────────────────────────────────────
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
    public function scopeForAdmin($query, $id)
    {
        return $query->where(function ($q) use ($id) {
            $q->where('admin_id', $id)->orWhereNull('admin_id');
        });
    }

    // ── Accessors ─────────────────────────────────────────────
    public function getTimeAgoAttribute(): string
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    // ── Static helpers ────────────────────────────────────────
    public static function sendOrderNotification(Order $order): void
    {
        self::create([
            'admin_id'  => null,   // broadcast to all admins
            'type'      => 'order',
            'title'     => 'New Order Placed',
            'message'   => 'Order #' . $order->order_number . ' placed by ' . $order->customer_full_name . ' — ৳' . number_format($order->total_order_price, 2),
            'url'       => route('admin.order-summary', $order->unique_id),
            'is_read'   => false,
        ]);
    }
}
