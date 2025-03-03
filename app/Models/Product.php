<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "products";
    protected $appends = ['total_variant', 'total_images'];
    protected $fillable = ['name', 'unit_price', 'discount_price', 'category_id', 'slug'];

    public function getTotalVariantAttribute()
    {
        return ProductVariant::where('product_id', $this->id)->count();
    }

    public function getTotalImagesAttribute()
    {
        return ProductImage::where('product_id', $this->id)->count();
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }

    public function sub_subcategory()
    {
        return $this->belongsTo(SubSubcategory::class, 'sub_subcategory_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'product_unit', 'id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

}
