<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::query();
        $data->latest();
        $data->when(request()->get('name'), function ($query) {
            $name = request()->get('name');
            $query->where('name', "LIKE", "%{$name}%");
        });
        $data->when(request()->get('status'), function ($query) {
            $query->where('status', request()->get('status'));
        });
        $categories = $data->paginate(15);
        return view('admin.attributes.category_list', compact('categories'));
    }

    public function create()
    {
        $route = route('admin.categories.store');
        return view('admin.attributes.category_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('categories', 'name')->whereNull('deleted_at')
            ],
            'icon' => 'nullable|sometimes|mimes:png|max:1024',
            'status' => 'required|in:active,inactive'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if ($request->file('icon')) {
            $category->icon = uploadImage($request->file('icon'), 'category');
        }
        $category->commission_rate = $request->commission_rate ?? 0.00;
        $category->status = $request->status;
        $category->created_by = Auth::id();
        $category->save();
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
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('categories', 'name')->whereNull('deleted_at')->ignore($id),
            ],
            'icon' => 'nullable|sometimes|mimes:png|max:1024',
            'status' => 'required|in:active,inactive'
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if ($request->file('icon')) {
            $category->icon = uploadImage($request->file('icon'), 'category');
        }
        $category->commission_rate = $request->commission_rate ?? 0.00;
        $category->status = $request->status;
        $category->created_by = Auth::id();
        $category->save();
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
        Category::findOrFail($id)->delete();
        return redirect()->route('admin.categories.index')->with(deleteMessage());
    }
}
