<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerOrderLog extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['seller_amount'];

    public function getSellerAmountAttribute() {
        return $this->order_amount - $this->total_commission;
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }

    public function seller()
    {
        return $this->belongsTo(Admin::class,'seller_id','id');
    }
}
