<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    public function index()
    {
        $data = Brand::query();
        $data->latest();
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
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('brands', 'name')->whereNull('deleted_at')
            ],
            'logo' => 'nullable|sometimes|mimes:jpg,jpeg,png|max:1024',
            'status' => 'required|max:10|in:active,inactive'
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        if ($request->file('logo')) {
            $brand->logo = uploadImage($request->file('logo'), 'brand');
        }
        $brand->status = $request->status;
        $brand->created_by = Auth::id();
        $brand->save();
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
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('brands', 'name')->whereNull('deleted_at')->ignore($id),
            ],
            'logo' => 'nullable|sometimes|mimes:jpg,jpeg,png|max:1024',
            'status' => 'required|max:10|in:active,inactive'
        ]);

        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        if ($request->file('logo')) {
            $brand->logo = uploadImage($request->file('logo'), 'brand');
        }
        $brand->status = $request->status;
        $brand->created_by = Auth::id();
        $brand->save();
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
}
