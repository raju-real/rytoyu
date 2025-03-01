<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes, ModelHelper;

    protected $table = "sub_categories";
    protected $appends = ['total_banner_images'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function getTotalBannerImagesAttribute()
    {
        return SubCategoryBanner::where('subcategory_id', $this->id)->count();
    }

    public function banner_images()
    {
        return $this->hasMany(SubCategoryBanner::class, 'subcategory_id', 'id');
    }
}
