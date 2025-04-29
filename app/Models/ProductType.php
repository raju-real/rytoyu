<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory, ModelHelper;

    protected $table = 'product_types';
    protected $appends = ['product_category_ids', 'category_ids', 'categories', 'category_names'];

    public function getProductCategoryIdsAttribute()
    {
        return  Product::whereHas('type', function ($q) {
            $q->where('id', $this->id);
        })
            ->pluck('category_id')
            ->unique()
            ->values();
    }

    public function getCategoryIdsAttribute()
    {
        return ProductTypeCategory::where("product_type_id", $this->id)->distinct('category_id')->pluck('category_id')->toArray();
    }

    public function getCategoriesAttribute()
    {
        $category_ids = $this->category_ids;
        return Category::whereIn('id', $category_ids)->select('id', 'name', 'slug')->get();
    }

    public function getCategoryNamesAttribute()
    {
        return $this->categories->pluck('name')->implode(', ');
    }
}
