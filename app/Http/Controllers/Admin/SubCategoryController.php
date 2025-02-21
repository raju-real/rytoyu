<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SubCategoryController extends Controller
{
    public function index()
    {
        $data = SubCategory::query();
        $data->sort();
        $data->when(request()->get('name'), function ($query) {
            $name = request()->get('name');
            $query->where('name', "LIKE", "%{$name}%");
        });
        $data->when(request()->get('category'), function ($query) {
            $query->where('category_id', categoryIdBySlug(request()->get('category')));
        });

        $data->when(request()->get('status'), function ($query) {
            $query->where('status', request()->get('status'));
        });
        $subcategories = $data->paginate(20);
        return view('admin.attributes.sub_category_list', compact('subcategories'));
    }

    public function create()
    {
        $route = route('admin.subcategories.store');
        return view('admin.attributes.sub_category_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('sub_categories', 'name')->whereNull('deleted_at')
            ],
            'category' => [
                'required',
                'int',
                Rule::exists('categories', 'id')->whereNull('deleted_at'),
            ],
            'icon' => 'nullable|sometimes|mimes:png|max:1024',
            'status' => 'required|in:active,inactive'
        ]);

        $sub_category = new SubCategory();
        $sub_category->category_id = $request->category;
        $sub_category->name = $request->name;
        $sub_category->slug = Str::slug($request->name);
        if ($request->file('icon')) {
            $sub_category->icon = uploadImage($request->file('icon'), 'sub_category');
        }
        $sub_category->status = $request->status;
        $sub_category->sorting_serial = SubCategory::where('category_id', $request->category)->max('sorting_serial') + 1;
        $sub_category->created_by = Auth::id();
        $sub_category->save();
        return redirect()->route('admin.subcategories.index')->with(successMessage());
    }


    public function edit($slug)
    {
        $subcategory = SubCategory::whereSlug($slug)->first();
        $route = route('admin.subcategories.update', $subcategory->id);
        return view('admin.attributes.sub_category_add_edit', compact('subcategory', 'route'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('sub_categories', 'name')->whereNull('deleted_at')->ignore($id),
            ],
            'category' => [
                'required',
                'int',
                Rule::exists('categories', 'id')->whereNull('deleted_at'),
            ],
            'icon' => 'nullable|sometimes|mimes:png|max:1024',
            'status' => 'required|in:active,inactive'
        ]);

        $sub_category = SubCategory::findOrFail($id);
        $sub_category->name = $request->name;
        $sub_category->category_id = $request->category;
        $sub_category->slug = Str::slug($request->name);
        if ($request->file('icon')) {
            $sub_category->icon = uploadImage($request->file('icon'), 'sub_category');
        }
        $sub_category->status = $request->status;
        $sub_category->created_by = Auth::id();
        $sub_category->save();
        return redirect()->route('admin.subcategories.index')->with(infoMessage());
    }

    public function updateSubCategoryStatus($id): \Illuminate\Http\JsonResponse
    {
        $sub_category = SubCategory::findOrFail($id);
        // Toggle status between 'active' and 'inactive'
        $sub_category->status = $sub_category->status === 'active' ? 'inactive' : 'active';
        if ($sub_category->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'SubCategory status updated successfully.',
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
        SubCategory::findOrFail($id)->delete();
        return redirect()->route('admin.subcategories.index')->with(deleteMessage());
    }

    public function sortSubCategories(Request $request)
    {
        $category_id = $request->input('category');
        if ($request->has('ids')) {
            $arr = $request->input('ids'); // Get the sorted array of subcategory IDs

            foreach ($arr as $sortOrder => $id) {
                // Update only the subcategories that belong to the given category_id
                $row = SubCategory::where('category_id', $category_id)->find($id);

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
