<?php

namespace App\Models;

use App\Models\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected static function booted()
    {
        // Product::withoutGlobalScope('sellerScope')->get();
        static::addGlobalScope(new SellerScope);
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function seller()
    {
        return $this->belongsTo(Admin::class,'seller_id','id');
    }
}
