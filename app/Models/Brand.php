<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes, ModelHelper;
    protected $table = "brands";
    protected $appends = ['total_banner_images'];
    public function getTotalBannerImagesAttribute() {
        return BrandBanner::where('brand_id',$this->id)->count();
    }

    public function banner_images()
    {
        return $this->hasMany(BrandBanner::class,'brand_id','id');
    }

}
