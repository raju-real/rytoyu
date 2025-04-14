<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderProduct extends Model
{
    use HasFactory;
    protected $table = "slider_products";
    protected $fillable = ['slider_id','product_id','sorting_serial'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
