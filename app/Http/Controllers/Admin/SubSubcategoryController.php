<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubcategory;
use App\Models\SubSubCategoryBanner;
use App\Traits\BannerImageValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SubSubcategoryController extends Controller
{
    use BannerImageValidation;
    public function index()
    {
        $data = SubSubcategory::query();
        $data->sort();
        $data->when(request()->get('name'),function($query) {
           $name = request()->get('name');
           $query->where('name',"LIKE","%{$name}%");
        });

        $data->when(request()->get('category'),function($query) {
           $query->where('category_id',categoryIdBySlug(request()->get('category')));
        });

        $data->when(request()->get('subcategory'),function($query) {
           $query->where('subcategory_id',subCategoryIdBySlug(request()->get('subcategory')));
        });

        $data->when(request()->get('status'),function($query) {
           $query->where('status',request()->get('status'));
        });
        $sub_subcategories = $data->paginate(20);
        return view('admin.attributes.sub_subcategory_list', compact('sub_subcategories'));
    }

    public function create()
    {
        $route = route('admin.sub-subcategories.store');
        return view('admin.attributes.sub_subcategory_add_edit', compact( 'route'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('sub_subcategories', 'name')
                    ->where(function ($query) use ($request) {
                        return $query->where('category_id', $request->category)
                            ->where('subcategory_id',$request->subcategory)
                            ->whereNull('deleted_at'); // Ensuring soft deletes are considered
                    }),
            ],
            'category' => [
                'required',
                'int',
                Rule::exists('categories', 'id')->whereNull('deleted_at'),
            ],
            'subcategory' => [
                'required',
                'int',
                Rule::exists('sub_categories', 'id')->whereNull('deleted_at'),
            ],
            'icon' => 'nullable|sometimes|mimes:png|max:1024',
            'status' => 'required|in:active,inactive'
        ];

        $validation = $this->bannerImageRules($request, 'sub_subcategory_banners');
        $rules = array_merge($rules, $validation['rules']);
        $messages = $validation['messages'];
        $request->validate($rules, $messages);

        $sub_category = new SubSubcategory();
        $sub_category->category_id = $request->category;
        $sub_category->subcategory_id = $request->subcategory;
        $sub_category->name = $request->name;
        $sub_category->slug = subCategorySlugById($request->subcategory).'-'.Str::slug($request->name);
        if ($request->file('icon')) {
            $sub_category->icon = uploadImage($request->file('icon'), 'sub_sub_category');
        }
        $sub_category->is_mega_menu = $request->is_mega_menu;
        $sub_category->status = $request->status;
        $sub_category->sorting_serial = SubSubcategory::where('category_id',$request->category)->where('subcategory_id',$request->subcategory)->max('sorting_serial') + 1;
        $sub_category->created_by = Auth::id();
        $sub_category->save();
        // Save banner images
        if ($request['banner_images'] && count($request['banner_images']) > 0) {
            foreach ($request['banner_images'] as $key => $image) {
                if (isset($image['image']) && $request->hasFile("banner_images.{$key}.image")) {
                    $banner_image = new SubSubCategoryBanner();
                    $banner_image->sub_subcategory_id = $sub_category->id;
                    $banner_image->image = uploadImage($request->file("banner_images.{$key}.image"), 'sub_sub_category');
                    $banner_image->save();
                }
            }
        }
        return redirect()->route('admin.sub-subcategories.index')->with(successMessage());
    }


    public function edit($slug)
    {
        $sub_subcategory = SubSubcategory::whereSlug($slug)->first();
        $route = route('admin.sub-subcategories.update', $sub_subcategory->id);
        return view('admin.attributes.sub_subcategory_add_edit', compact('sub_subcategory',  'route'));
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('sub_subcategories', 'name')
                    ->where(function ($query) use ($request) {
                        return $query->where('category_id', $request->category)
                            ->where('subcategory_id',$request->subcategory)
                            ->whereNull('deleted_at'); // Ensuring soft deletes are considered
                    })->ignore($id),
            ],
            'category' => [
                'required',
                'int',
                Rule::exists('categories', 'id')->whereNull('deleted_at')
            ],
            'subcategory' => [
                'required',
                'int',
                Rule::exists('sub_categories', 'id')->whereNull('deleted_at')
            ],
            'icon' => 'nullable|sometimes|mimes:png|max:1024',
            'status' => 'required|in:active,inactive'
        ];

        $validation = $this->bannerImageRules($request, 'sub_subcategory_banners');
        $rules = array_merge($rules, $validation['rules']);
        $messages = $validation['messages'];
        $request->validate($rules, $messages);

        $sub_category = SubSubcategory::findOrFail($id);
        $sub_category->category_id = $request->category;
        $sub_category->subcategory_id = $request->subcategory;
        $sub_category->name = $request->name;
        $sub_category->slug = subCategorySlugById($request->subcategory).'-'.Str::slug($request->name);
        if ($request->file('icon')) {
            $sub_category->icon = uploadImage($request->file('icon'), 'sub_sub_category');
        }
        $sub_category->is_mega_menu = $request->is_mega_menu;
        $sub_category->status = $request->status;
        $sub_category->created_by = Auth::id();
        $sub_category->save();
        // Update or create banner images
        $existingImageIds = $sub_category->banner_images()->pluck('id')->toArray();
        $requestImageIds = collect($request->banner_images)->pluck('id')->filter()->toArray();
        $imagesToDelete = array_diff($existingImageIds, $requestImageIds);
        if (!empty($imagesToDelete)) {
            $sub_category->banner_images()
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
                $banner_image = $image['is_new'] == 0 ? SubSubCategoryBanner::find($image['id']) : new SubSubCategoryBanner();

                if (isset($image['image']) && $request->hasFile("banner_images.{$key}.image")) {
                    if ($image['is_new'] == 0 && file_exists($banner_image->image)) {
                        unlink($banner_image->image);
                    }
                    $banner_image->image = uploadImage($request->file("banner_images.{$key}.image"), 'sub_sub_category');
                }
                $banner_image->sub_subcategory_id = $id;
                $banner_image->save();
            }
        }
        return redirect()->route('admin.sub-subcategories.index')->with(infoMessage());
    }

    public function updateSubSubCategoryStatus($id): \Illuminate\Http\JsonResponse
    {
        $sub_category = SubSubcategory::findOrFail($id);
        // Toggle status between 'active' and 'inactive'
        $sub_category->status = $sub_category->status === 'active' ? 'inactive' : 'active';
        if ($sub_category->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'SubSubcategory status updated successfully.',
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
        SubSubcategory::findOrFail($id)->delete();
        return redirect()->route('admin.subcategories.index')->with(deleteMessage());
    }

    public function sortSubSubCategories(Request $request)
    {
        $category_id = $request->input('category');
        $subcategory_id = $request->input('subcategory');

        if ($request->has('ids')) {
            $arr = $request->input('ids'); // Get the sorted array of subcategory IDs

            foreach ($arr as $sortOrder => $id) {
                // Update only the subcategories that belong to the given category_id
                $row = SubSubcategory::where('category_id', $category_id)->where('subcategory_id',$subcategory_id)->find($id);

                if ($row) {
                    $row->sorting_serial = $sortOrder + 1; // Update sorting_serial
                    $row->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Sorting updated successfully.'
            ]);
        }
    }
}
