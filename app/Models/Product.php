<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, ModelHelper;

    protected $table = "products";
    protected $appends = ['total_variant','default_variant', 'total_images','seller_shop_name'];
    protected $fillable = ['name', 'unit_price', 'discount_price', 'category_id', 'slug'];

    public function seller()
    {
        return $this->belongsTo(Admin::class,'seller_id','id');
    }

    public function getTotalVariantAttribute()
    {
        return ProductVariant::where('product_id', $this->id)->count();
    }

    public function getDefaultVariantAttribute()
    {
        return ProductVariant::where('product_id',$this->id)->where('is_default',1)->first();
    }

    public function getTotalImagesAttribute()
    {
        return ProductImage::where('product_id', $this->id)->count();
    }

    public function getSellerShopNameAttribute()
    {
        return SellerShop::where('seller_id',$this->seller_id)->first()->shop_name ?? '';
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
