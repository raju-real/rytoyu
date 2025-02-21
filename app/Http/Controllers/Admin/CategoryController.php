<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryBanner;
use App\Traits\BannerImageValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    use BannerImageValidation;

    public function index()
    {
        $data = Category::query();
        $data->sort();
        $data->when(request()->get('name'), function ($query) {
            $name = request()->get('name');
            $query->where('name', "LIKE", "%{$name}%");
        });
        $data->when(request()->get('status'), function ($query) {
            $query->where('status', request()->get('status'));
        });
        $categories = $data->paginate(20);
        return view('admin.attributes.category_list', compact('categories'));
    }

    public function create()
    {
        $route = route('admin.categories.store');
        return view('admin.attributes.category_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('categories', 'name')->whereNull('deleted_at')
            ],
            'icon' => 'nullable|sometimes|mimes:png|max:1024',
            'image' => 'required|image|mimes:jpeg,jpg,png|dimensions:width=748,height=378|max:1024',
            'is_mega_menu' => 'required|in:yes,no',
            'status' => 'required|in:active,inactive',
        ];
        // Get banner image validation rules and messages
        $validation = $this->bannerImageRules($request, 'category_banners');
        $rules = array_merge($rules, $validation['rules']); // Merge rules
        $messages = $validation['messages']; // Get custom messages
        // Validate request with both rules and custom messages
        $request->validate($rules, $messages);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if ($request->file('icon')) {
            $category->icon = uploadImage($request->file('icon'), 'category');
        }
        if ($request->file('image')) {
            $category->image = uploadImage($request->file('image'), 'category');
        }
        $category->commission_rate = $request->commission_rate ?? 0.00;
        $category->status = $request->status;
        $category->is_mega_menu = $request->is_mega_menu;
        $category->sorting_serial = Category::max('sorting_serial') + 1;
        $category->created_by = Auth::id();
        $category->save();
        // Save banner images
        if ($request['banner_images'] && count($request['banner_images']) > 0) {
            foreach ($request['banner_images'] as $key => $image) {
                if (isset($image['image']) && $request->hasFile("banner_images.{$key}.image")) {
                    $banner_image = new CategoryBanner();
                    $banner_image->category_id = $category->id;
                    $banner_image->image = uploadImage($request->file("banner_images.{$key}.image"), 'category');
                    $banner_image->save();
                }
            }
        }
        return redirect()->route('admin.categories.index')->with(successMessage());
    }


    public function edit($slug)
    {
        $category = Category::whereSlug($slug)->first();
        $route = route('admin.categories.update', $category->id);
        return view('admin.attributes.category_add_edit', compact('category', 'route'));
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('categories', 'name')->whereNull('deleted_at')->ignore($id),
            ],
            'icon' => 'nullable|sometimes|mimes:png|max:1024',
            'image' => 'nullable|sometimes|image|mimes:jpeg,jpg,png|dimensions:width=748,height=378|max:1024',
            'is_mega_menu' => 'required|in:yes,no',
            'status' => 'required|in:active,inactive',
        ];
        // Get banner image validation rules and messages
        $validation = $this->bannerImageRules($request, 'category_banners');
        $rules = array_merge($rules, $validation['rules']); // Merge rules
        $messages = $validation['messages']; // Get custom messages
        // Validate request with both rules and custom messages
        $request->validate($rules, $messages);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if ($request->file('icon')) {
            $category->icon = uploadImage($request->file('icon'), 'category');
        }
        if ($request->file('image')) {
            $category->image = uploadImage($request->file('image'), 'category');
        }
        $category->commission_rate = $request->commission_rate ?? 0.00;
        $category->status = $request->status;
        $category->created_by = Auth::id();
        $category->save();
        // Update or create banner images
        $existingImageIds = $category->banner_images()->pluck('id')->toArray();
        $requestImageIds = collect($request->banner_images)->pluck('id')->filter()->toArray();
        $imagesToDelete = array_diff($existingImageIds, $requestImageIds);
        if (!empty($imagesToDelete)) {
            $category->banner_images()
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
                $banner_image = $image['is_new'] == 0 ? CategoryBanner::find($image['id']) : new CategoryBanner();

                if (isset($image['image']) && $request->hasFile("banner_images.{$key}.image")) {
                    if ($image['is_new'] == 0 && file_exists($banner_image->image)) {
                        unlink($banner_image->image);
                    }
                    $banner_image->image = uploadImage($request->file("banner_images.{$key}.image"), 'category');
                }
                $banner_image->category_id = $id;
                $banner_image->save();
            }
        }
        return redirect()->route('admin.categories.index')->with(infoMessage());
    }

    public function updateCategoryStatus($id): \Illuminate\Http\JsonResponse
    {
        $category = Category::findOrFail($id);
        // Toggle status between 'active' and 'inactive'
        $category->status = $category->status === 'active' ? 'inactive' : 'active';
        if ($category->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Category status updated successfully.',
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
        $category = Category::findOrFail($id);
        $category->banner_images()
            ->get()
            ->each(function ($image) {
                if ($image->image_path && file_exists($image->image)) {
                    unlink($image->image);
                }
                $image->delete();
            });
        $category->delete();
        return redirect()->route('admin.categories.index')->with(deleteMessage());
    }

    public function sortCategories(Request $request)
    {
        if ($request->has('ids')) {
            $arr = explode(',', $request->input('ids'));

            foreach ($arr as $sortOrder => $id) {
                $row = Category::find($id);
                $row->sorting_serial = $sortOrder + 1;
                $row->save();
            }
            return ['success' => true, 'message' => 'Updated'];
        }
    }
}
