<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubSubcategory extends Model
{
    use HasFactory, SoftDeletes, ModelHelper;
    protected $table = "sub_subcategories";
    protected $appends = ['total_banner_images'];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class,'subcategory_id','id');
    }

    public function getTotalBannerImagesAttribute()
    {
        return SubSubCategoryBanner::where('sub_subcategory_id', $this->id)->count();
    }

    public function banner_images()
    {
        return $this->hasMany(SubSubCategoryBanner::class, 'sub_subcategory_id', 'id');
    }
}
