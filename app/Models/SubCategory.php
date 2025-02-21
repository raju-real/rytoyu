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

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
