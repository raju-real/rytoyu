<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewInProduct extends Model
{
    use HasFactory, ModelHelper;
    protected $table = 'new_in_products';

    protected $fillable = ['product_id','sorting_serial'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
