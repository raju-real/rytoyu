<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('category-wise-subcategories/{category_id}', function ($category_id) {
    $cat_id = is_numeric($category_id) ? $category_id : categoryIdBySlug($category_id);
    $append_value = is_numeric($category_id) ? 'id' : 'slug';
    $subcategories =  \App\Models\SubCategory::active()->where('category_id', $cat_id)->select('id', 'category_id', 'name', 'slug')->orderBy('name')->get();
    return response()->json([
        'subcategories' => $subcategories,
        'append_value' => $append_value
    ]);
});

Route::get('subcategory-wise-sub-subcategories/{subcategory_id}', function ($subcategory_id) {
    $sub_cat_id = is_numeric($subcategory_id) ? $subcategory_id : subCategoryIdBySlug($subcategory_id);
    $append_value = is_numeric($subcategory_id) ? 'id' : 'slug';
    $sub_sub_categories =  \App\Models\SubSubCategory::active()->where('subcategory_id', $sub_cat_id)->select('id', 'subcategory_id', 'name', 'slug')->orderBy('name')->get();
    return response()->json([
        'sub_subcategories' => $sub_sub_categories,
        'append_value' => $append_value
    ]);
});
