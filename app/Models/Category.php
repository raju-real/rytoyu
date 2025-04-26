<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes, ModelHelper;
    protected $table = "categories";
    protected $appends = ['total_banner_images'];
    public function getTotalBannerImagesAttribute() {
        return CategoryBanner::where('category_id',$this->id)->count();
    }

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class,'category_id','id');
    }

    public function banner_images()
    {
        return $this->hasMany(CategoryBanner::class,'category_id','id');
    }

}
