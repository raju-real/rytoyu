<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Scopes\ProductApproved;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('user_has_shop')->only(['create', 'store', 'edit', 'destroy']);
    }

    public function index()
    {
        $data = Product::query();

        $data->where('seller_id', authSellerId());

        $data->when(request()->filled('brand'), function ($query) {
            $query->where('brand_id', brandIdBySlug(request()->get('brand')));
        });

        $data->when(request()->filled('category'), function ($query) {
            $query->where('category_id', categoryIdBySlug(request()->get('category')));
        });

        $data->when(request()->filled('subcategory'), function ($query) {
            $query->where('subcategory_id', subCategoryIdBySlug(request()->get('subcategory')));
        });

        $data->when(request()->filled('sub_subcategory'), function ($query) {
            $query->where('sub_subcategory_id', subSubCategoryIdBySlug(request()->get('sub_subcategory')));
        });

        if (request()->filled('request_status')) {
            $data = $data->withoutGlobalScope(ProductApproved::class);
            $data->where('request_status', request()->get('request_status'));
        }

        $data->when(request()->filled('status'), function ($query) {
            $query->where('status', request()->get('status'));
        });

        if (request()->filled('stock_less_than')) {
            $stockLimit = request()->get('stock_less_than');
            $data->whereHas('variants', function ($query) use ($stockLimit) {
                $query->where('inventory', '<', $stockLimit);
            });
        }

        $products = $data->latest()->paginate(20);

        return view('admin.products.product_list', compact('products'));
    }


    public function create()
    {
        $route = route('admin.products.store');
        return view('admin.products.product_add_edit', compact('route'));
    }

    public function getProductVariantsData()
    {
        $sizes = allSizes()->map(function ($size) {
            return ['id' => $size->id, 'name' => $size->name];
        });

        $colors = allColors()->map(function ($color) {
            return ['id' => $color->id, 'name' => $color->name];
        });

        return Response::json([
            'sizes' => $sizes,
            'colors' => $colors,
        ]);
    }

    public function storeOptimized(ProductRequest $request)
    {
        $validatedData = $request->validated();
        DB::transaction(function () use ($request, $validatedData) {
            // Create product
            $product = Product::create([
                'product_code' => $validatedData['product_code'],
                'name' => $validatedData['name'],
                'slug' => Str::slug("{$validatedData['product_code']}-{$validatedData['name']}"),
                'category_id' => $validatedData['category'],
                'subcategory_id' => $validatedData['subcategory'],
                'sub_subcategory_id' => $validatedData['sub_subcategory'],
                'brand_id' => $validatedData['brand'],
                'product_unit' => $validatedData['unit'],
                'product_details' => $validatedData['product_details'],
                'product_specification' => $validatedData['product_specification'] ?? null,
                'short_description' => $validatedData['short_description'],
                'special_note' => $validatedData['special_note'],
                'warranty' => $validatedData['warranty'] ?? null,
                'video_link' => $validatedData['video_link'],
                'product_tags' => $request->tags ? implode(',', $request->tags) : null,
                'is_exchangeable' => $validatedData['is_exchangeable'] ?? 0,
                'is_refundable' => $validatedData['is_refundable'] ?? 0,
                'listed_on' => $validatedData['listed_on'] ?? 'featured',
                'weight' => $validatedData['weight'] ?? null,
                'status' => $validatedData['status'],
                'thumbnail_path' => $request->hasFile('product_thumbnail')
                    ? uploadImage($request->file('product_thumbnail'), 'products')
                    : null,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            // Create product variants if provided
            if (!empty($validatedData['variants'])) {
                $variants = collect($validatedData['variants'])->map(function ($variant) use ($product) {
                    return [
                        'product_id' => $product->id,
                        'size_id' => $variant['size'],
                        'color_id' => $variant['color'],
                        'unit_price' => $variant['unit_price'],
                        'discount_price' => $variant['discount_price'],
                        'is_default' => $variant['is_default'] ?? 0,
                    ];
                })->toArray();
                ProductVariant::insert($variants);
            }

            // Create product images if provided
            if ($request->has('images')) {
                $images = collect($request->images)->map(function ($image, $key) use ($request, $product) {
                    if (isset($image['image']) && $request->hasFile("images.{$key}.image")) {
                        return [
                            'product_id' => $product->id,
                            'image_path' => uploadImage($request->file("images.{$key}.image"), 'products'),
                        ];
                    }
                    return null;
                })->filter()->toArray();

                ProductImage::insert($images);
            }
        });

        // Return response
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product has been saved successfully!'
            ]);
        }

        return redirect()->route('admin.products.index')->with(successMessage());
    }


    public function store(ProductRequest $request)
    {
        $validatedData = $request->validated();
        $product = new Product();
        $product->seller_id = authSellerId();
        $product->product_code = $request->product_code;
        $product->name = $request->name;
        $product->slug = Str::slug($validatedData['product_code'] . '-' . $validatedData['name']);
        $product->product_type_id = $validatedData['product_type'];
        $product->category_id = $validatedData['category'];
        $product->subcategory_id = $validatedData['subcategory'];
        $product->sub_subcategory_id = $validatedData['sub_subcategory'];
        $product->brand_id = $validatedData['brand'];
        $product->product_unit = $validatedData['unit'];
        $product->product_details = $validatedData['product_details'];
        $product->product_specification = $validatedData['product_specification'] ?? null;
        $product->product_compare = $validatedData['product_compare'] ?? null;
        $product->short_description = $validatedData['short_description'];
        $product->special_note = $validatedData['special_note'];
        $product->warranty = $validatedData['warranty'] ?? Null;
        $product->video_link = $validatedData['video_link'];
        $product->product_tags = $request->tags ? implode(',', $request->tags) : Null;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        if ($request->hasFile('meta_image')) {
            $product->meta_image = uploadImage($request->file('meta_image'), 'products/meta');
        }
        $product->is_exchangeable = $request->is_exchangeable;
        $product->is_refundable = $request->is_refundable;
        $product->listed_on = $request->listed_on ?? 'featured';
        $product->weight = $request->weight;
        if (authAdminType() === 'seller') {
            $product->request_status = 'pending';
        } else {
            $product->request_status = 'approved';
        }
        $product->status = $request->status;
        $product->created_by = Auth::id();
        $product->updated_by = Auth::id();

        if ($request->hasFile('product_thumbnail')) {
            $product->thumbnail_path = uploadImage($request->file('product_thumbnail'), 'products');
        }

        if ($product->save()) {
            // Save product variants
            if (!empty($validatedData['variants'])) {
                foreach ($validatedData['variants'] as $key => $variant) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size_id' => $variant['size'],
                        'color_id' => $variant['color'],
                        'unit_price' => $variant['unit_price'],
                        'discount_price' => $variant['discount_price'],
                        'inventory' => $variant['inventory'],
                        'is_default' => $variant['is_default'] ?? 0
                    ]);
                }
                // Update product table price
                $this->updatePricing($product->id);
            }

            // Save product images
            if ($request['images'] && count($request['images']) > 0) {
                foreach ($request['images'] as $key => $image) {
                    if (isset($image['image']) && $request->hasFile("images.{$key}.image")) {
                        $product_image = new ProductImage();
                        $product_image->product_id = $product->id;
                        $product_image->image_path = uploadImage($request->file("images.{$key}.image"), 'products');
                        $product_image->save();
                    }
                }
            }
            // Return response
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'type' => 'added',
                    'message' => 'Product has been saved successfully!'
                ]);
            } else {
                return redirect()->route('admin.products.index')->with(successMessage());
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Product information not saved.Something wrong!'
            ]);
        }
    }


    public function edit($slug)
    {
        $product = Product::withoutGlobalScope(ProductApproved::class)->whereSlug($slug)->firstOrFail();
        $route = route('admin.products.update', $product->id);
        return view('admin.products.product_add_edit', compact('product', 'route'));
    }

    public function show($slug)
    {
        $product = Product::withoutGlobalScope(ProductApproved::class)->whereSlug($slug)->firstOrFail();
        return view('admin.products.product_details', compact('product', 'product'));
    }


    public function update(ProductRequest $request, $id)
    {
        $validatedData = $request->validated();
        $product = Product::withoutGlobalScope(ProductApproved::class)->findOrFail($id);
        $product->product_code = $request->product_code;
        $product->name = $request->name;
        $product->slug = Str::slug($validatedData['product_code'] . '-' . $validatedData['name']);
        $product->product_type_id = $validatedData['product_type'];
        $product->category_id = $validatedData['category'];
        $product->subcategory_id = $validatedData['subcategory'];
        $product->sub_subcategory_id = $validatedData['sub_subcategory'];
        $product->brand_id = $validatedData['brand'];
        $product->product_unit = $validatedData['unit'];
        $product->product_details = $validatedData['product_details'];
        $product->product_specification = $validatedData['product_specification'] ?? null;
        $product->product_compare = $validatedData['product_compare'] ?? null;
        $product->short_description = $validatedData['short_description'];
        $product->special_note = $validatedData['special_note'];
        $product->warranty = $validatedData['warranty'] ?? Null;
        $product->video_link = $validatedData['video_link'];
        $product->product_tags = $request->tags ? implode(',', $request->tags) : Null;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        if ($request->hasFile('meta_image')) {
            $product->meta_image = uploadImage($request->file('meta_image'), 'products/meta');
        }
        $product->is_exchangeable = $request->is_exchangeable;
        $product->is_refundable = $request->is_refundable;
        $product->listed_on = $request->listed_on ?? 'featured';
        $product->weight = $request->weight;
        $product->status = $request->status;
        $product->updated_by = Auth::id();

        if ($request->hasFile('product_thumbnail')) {
            $product->thumbnail_path = uploadImage($request->file('product_thumbnail'), 'products');
        }

        if ($product->save()) {
            // Update or create product variants
            if (!empty($validatedData['variants'])) {
                // Get existing variants and request variant IDs
                $existingVariants = $product->variants()->pluck('id')->toArray();
                $requestVariantIds = collect($request->input('variants', []))
                    ->map(fn($variant) => $variant['variant_id'] ?? null)
                    ->filter()
                    ->toArray();
                // Delete removed variants
                $product->variants()->whereIn('id', array_diff($existingVariants, $requestVariantIds))->forceDelete();
                // Process variants
                foreach ($validatedData['variants'] as $variant) {
                    $variantData = [
                        'is_default' => $variant['is_default'] ?? 0,
                        'size_id' => $variant['size'] ?? null,
                        'color_id' => $variant['color'] ?? null,
                        'unit_price' => $variant['unit_price'],
                        'discount_price' => $variant['discount_price'] ?? 0,
                        'inventory' => $variant['inventory'] ?? 0,
                    ];
                    // Update or create variant
                    $product->variants()->updateOrCreate(['id' => $variant['variant_id'] ?? null], $variantData);
                }
                // Update product table price
                $this->updatePricing($product->id);
            }
            // Update or create product images
            // Get existing image IDs from the database
            $existingImageIds = $product->images()->pluck('id')->toArray();
            // Collect image IDs from the request
            $requestImageIds = collect($request->images)->pluck('image_id')->filter()->toArray();
            // Determine and delete images that are no longer in the request
            $imagesToDelete = array_diff($existingImageIds, $requestImageIds);
            if (!empty($imagesToDelete)) {
                $product->images()
                    ->whereIn('id', $imagesToDelete)
                    ->get()
                    ->each(function ($image) {
                        // Delete the image file from storage
                        if ($image->image_path && file_exists($image->image_path)) {
                            unlink($image->image_path);
                        }
                        $image->forceDelete();
                    });
            }
            // Process and save images from the request
            //dd(count($request->images));
            if ($request->images) {
                foreach ($request->images as $key => $image) {
                    $productImage = isset($image['image_id']) ? ProductImage::find($image['image_id']) : new ProductImage();

                    if (isset($image['image']) && $request->hasFile("images.{$key}.image")) {
                        if ($image['is_new'] == 0 && file_exists($productImage->image_path)) {
                            unlink($productImage->image_path);
                        }
                        $productImage->image_path = uploadImage($request->file("images.{$key}.image"), 'products');
                    }
                    $productImage->product_id = $product->id;
                    $productImage->save();
                }
            }

            // Return response
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'type' => 'updated',
                    'message' => 'Product has been updated successfully!'
                ]);
            } else {
                return redirect()->route('admin.products.index')->with(successMessage());
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Product information not updated. Something went wrong!'
            ]);
        }
    }

    public function updateProductStatus($id): \Illuminate\Http\JsonResponse
    {
        $sub_category = Product::withoutGlobalScope(ProductApproved::class)->findOrFail($id);
        // Toggle status between 'active' and 'inactive'
        $sub_category->status = $sub_category->status === 'active' ? 'inactive' : 'active';
        if ($sub_category->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Brand status updated successfully.',
            ]);
        }
        // Optional: Handle failure case if needed
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update category status.',
        ], 500);
    }

    /**
     * Delete Products
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $product = Product::withoutGlobalScope(ProductApproved::class)->findOrFail($id);
        $product->variants()->delete();
        $product->images()->delete();
        $product->delete();
        return redirect()->route('admin.products.index')->with(deleteMessage());
    }

    public function productVariants($product_id = null): \Illuminate\Http\JsonResponse
    {
        $product = Product::withoutGlobalScope(ProductApproved::class)->findOrFail($product_id);
        return response()->json([
            'success' => true,
            'product_name' => $product->name,
            'category_name' => $product->category->name ?? 'N/A',
            'subcategory_name' => $product->subcategory->name ?? 'N/A',
            'sub_subcategory_name' => $product->sub_subcategory->name ?? 'N/A',
            'brand_name' => $product->brand->name ?? 'N/A',
            'variants' => $product->variants
        ]);
    }

    protected function updatePricing($product_id): void
    {
        $defaultVariant = ProductVariant::withoutGlobalScope(ProductApproved::class)->where('product_id', $product_id)
            ->where('is_default', 1)
            ->first();
        Product::where('id', $product_id)->update([
            'unit_price' => $defaultVariant->unit_price,
            'discount_price' => $defaultVariant->discount_price
        ]);
    }

    public function updateProductVariant(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->inventory = $request->inventory;
        if ($request->has('unit_price')) {
            $variant->unit_price = $request->unit_price;
        }
        if ($request->has('discount_price')) {
            $variant->discount_price = $request->discount_price;
        }

        if ($variant->save()) {
            // If this variant is default, update product pricing
            if ($variant->is_default) {
                $this->updatePricing($variant->product_id);
            }
            return response()->json([
                'success' => true,
                'message' => 'Variant updated successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to update variant.'
        ], 500);
    }
}
