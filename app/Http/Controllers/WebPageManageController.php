<?php

namespace App\Http\Controllers;

use App\Models\NewInProduct;
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
}
