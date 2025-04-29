<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\NewInProduct;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductTypeCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WebPageManageController extends Controller
{
    // New in products
    public function newInProducts()
    {
        return view('admin.sections.new_in_products');
    }

    public function getNewInProducts()
    {
        $products = NewInProduct::with([
            'product' => function ($product) {
                $product->select('id', 'seller_id', 'product_code', 'name', 'thumbnail_path');
            }
        ])
            ->sort()
            ->get();

        return response()->json($products);
    }

    public function addNewInProducts(Request $request)
    {
        $request->validate([
            'product_id' => [
                'required',
                Rule::exists('products', 'id'),
            ],
        ]);

        $productId = $request->product_id;
        $exists = NewInProduct::where('product_id', $productId)->exists();
        if ($exists) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Product already exists on new in sections!',
            ], 400);
        }
        // Get the max sorting serial for the slider
        $maxSortingSerial = NewInProduct::max('sorting_serial') ?? 0;
        // Add the product to the slider
        NewInProduct::create([
            'product_id' => $productId,
            'sorting_serial' => $maxSortingSerial + 1,
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'Product added successfully to the slider!',
        ]);
    }

    public function deleteNewInProduct()
    {
        $product_id = request()->get('product_id');
        $deleted = NewInProduct::where('product_id', $product_id)
            ->delete();

        if ($deleted) {
            $products = NewInProduct::sort()->get();
            foreach ($products as $index => $product) {
                $product->update(['sorting_serial' => $index + 1]);
            }
            return response()->json(['status' => 'success', 'message' => 'Product deleted successfully!']);
        }

        return response()->json(['status' => 'error', 'message' => 'Failed to delete product.'], 500);
    }

    public function updateNewInProductSorting(Request $request)
    {
        if ($request->has('ids')) {
            $arr = $request->input('ids');
            foreach ($arr as $sortOrder => $id) {
                $row = NewInProduct::find($id);
                $row->sorting_serial = $sortOrder + 1;
                $row->save();
            }
            return ['success' => true, 'message' => 'Updated'];
        }
    }

    public function manageProductType()
    {
        $product_types = ProductType::active()->sort()->get();
        return view('admin.sections.manage_product_types', compact('product_types'));
    }

    public function productTypeCategoryBound($type_slug)
    {
        $type = ProductType::whereSlug($type_slug)->firstOrFail();
        $categories = Category::whereIn('id',  $type->product_category_ids)->select('id', 'name')->get();
        return view('admin.sections.bound_category_product_types', compact('type', 'categories'));
    }

    public function boundCategoryOnProductType(Request $request, $type_id)
    {
        $category_ids = $request->input('category_ids', []);
        if (empty($category_ids)) {
            return redirect()->route('admin.manage-product-types')->with(infoMessage('No categories selected.'));
        }
        // Delete existing bindings for the product type
        ProductTypeCategory::where('product_type_id', $type_id)->delete();
        // Prepare data for bulk insert
        $data = collect($category_ids)->map(function ($category_id) use ($type_id) {
            return [
                'product_type_id' => $type_id,
                'category_id' => $category_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();
        ProductTypeCategory::insert($data);
        return redirect()->route('admin.manage-product-types')->with(infoMessage('Categories bound successfully.'));
    }

}
