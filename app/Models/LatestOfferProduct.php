<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LatestOfferProduct extends Model
{
    use HasFactory, ModelHelper;
    protected $table = "latest_offer_products";

    protected $fillable = ['seller_id', 'product_id', 'sorting_serial'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
