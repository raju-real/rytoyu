<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $appends = ['size_name', 'color_name', 'stock_status'];

    public function color()
    {
        return $this->belongsTo(Color::class,'color_id','id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class,'size_id','id');
    }

    public function getSizeNameAttribute()
    {
        return Size::find($this->size_id)->name ?? 'N/A';
    }

    public function getColorNameAttribute()
    {
        return Color::find($this->color_id)->name ?? 'N/A';
    }

    public function getStockStatusAttribute()
    {
        return $this->inventory > 0 ? 'In Stock' : 'Out of Stock';
    }
}
