<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory, ModelHelper;
    protected $table  = 'sliders';
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(SliderProduct::class,'slider_id','id');
    }
}
