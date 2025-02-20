<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $appends = ['size_name','color_name'];
    public function getSizeNameAttribute()
    {
        return Size::find($this->size_id)->name ?? 'N/A';
    }public function getColorNameAttribute()
{
        return Color::find($this->color_id)->name ?? 'N/A';
    }
}
