<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\BrandBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    public function index()
    {
        $data = Brand::query();
        $data->sort();
        $data->when(request()->get('name'),function($query) {
           $name = request()->get('name');
           $query->where('name',"LIKE","%{$name}%");
        });
        $data->when(request()->get('status'),function($query) {
           $query->where('status',request()->get('status'));
        });
        $brands = $data->paginate(15);
        return view('admin.attributes.brand_list', compact('brands'));
    }

    public function create()
    {
        $route = route('admin.brands.store');
        return view('admin.attributes.brand_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('brands', 'name')->whereNull('deleted_at')
            ],
            'logo' => 'required|image|mimes:jpeg,jpg,png|dimensions:width=105,height=105|max:1024',
            'image' => 'required|image|mimes:jpeg,jpg,png|dimensions:width=335,height=400|max:1024',
            'status' => 'required|max:10|in:active,inactive'
        ];

        $validation = $this->bannerImageRules($request, 'category_banners');
        $rules = array_merge($rules, $validation['rules']);
        $messages = $validation['messages'];
        $request->validate($rules, $messages);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        if ($request->file('logo')) {
            $brand->logo = uploadImage($request->file('logo'), 'brand');
        }
        if ($request->file('image')) {
            $brand->image = uploadImage($request->file('image'), 'brand');
        }
        $brand->status = $request->status;
        $brand->created_by = Auth::id();
        $brand->save();
        // Save banner images
        if ($request['banner_images'] && count($request['banner_images']) > 0) {
            foreach ($request['banner_images'] as $key => $image) {
                if (isset($image['image']) && $request->hasFile("banner_images.{$key}.image")) {
                    $banner_image = new BrandBanner();
                    $banner_image->brand_id = $brand->id;
                    $banner_image->image = uploadImage($request->file("banner_images.{$key}.image"), 'brand');
                    $banner_image->save();
                }
            }
        }
        if($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'id' => $brand->id,
                'name' => $brand->name
            ]);
        } else {
            return redirect()->route('admin.brands.index')->with(successMessage());
        }
    }


    public function edit($slug)
    {
        $brand = Brand::whereSlug($slug)->first();
        $route = route('admin.brands.update', $brand->id);
        return view('admin.attributes.brand_add_edit', compact('brand', 'route'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('brands', 'name')->whereNull('deleted_at')->ignore($id)
            ],
            'logo' => 'nullable|sometimes|image|mimes:jpeg,jpg,png|dimensions:width=105,height=105|max:1024',
            'image' => 'nullable|sometimes|image|mimes:jpeg,jpg,png|dimensions:width=335,height=400|max:1024',
            'status' => 'required|max:10|in:active,inactive'
        ];

        $validation = $this->bannerImageRules($request, 'category_banners');
        $rules = array_merge($rules, $validation['rules']);
        $messages = $validation['messages'];
        $request->validate($rules, $messages);

        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        if ($request->file('logo')) {
            $brand->logo = uploadImage($request->file('logo'), 'brand');
        }
        if ($request->file('image')) {
            $brand->image = uploadImage($request->file('image'), 'brand');
        }
        $brand->status = $request->status;
        $brand->sorting_serial = Brand::max('sorting_serial') + 1;
        $brand->created_by = Auth::id();
        $brand->save();
        // Update or create banner images
        $existingImageIds = $brand->banner_images()->pluck('id')->toArray();
        $requestImageIds = collect($request->banner_images)->pluck('id')->filter()->toArray();
        $imagesToDelete = array_diff($existingImageIds, $requestImageIds);
        if (!empty($imagesToDelete)) {
            $brand->banner_images()
                ->whereIn('id', $imagesToDelete)
                ->get()
                ->each(function ($image) {
                    if ($image->image && file_exists($image->image)) {
                        unlink($image->image);
                    }
                    $image->delete();
                });
        }
        if ($request->banner_images) {
            foreach ($request->banner_images as $key => $image) {
                $banner_image = $image['is_new'] == 0 ? BrandBanner::find($image['id']) : new BrandBanner();

                if (isset($image['image']) && $request->hasFile("banner_images.{$key}.image")) {
                    if ($image['is_new'] == 0 && file_exists($banner_image->image)) {
                        unlink($banner_image->image);
                    }
                    $banner_image->image = uploadImage($request->file("banner_images.{$key}.image"), 'brand');
                }
                $banner_image->brand_id = $id;
                $banner_image->save();
            }
        }
        return redirect()->route('admin.brands.index')->with(infoMessage());
    }

    public function updateBrandStatus($id): \Illuminate\Http\JsonResponse
    {
        $sub_category = Brand::findOrFail($id);
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


    public function destroy($id)
    {
        Brand::findOrFail($id)->delete();
        return redirect()->route('admin.brands.index')->with(deleteMessage());
    }

    public function sortBrands(Request $request)
    {
        if ($request->has('ids')) {
            $arr = explode(',', $request->input('ids'));

            foreach ($arr as $sortOrder => $id) {
                $row = Brand::find($id);
                $row->sorting_serial = $sortOrder + 1;
                $row->save();
            }
            return ['success' => true, 'message' => 'Updated'];
        }
    }
}
