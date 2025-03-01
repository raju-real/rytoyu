<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductTypeController extends Controller
{
    public function index()
    {
        $data = ProductType::query();
        $data->sort();
        $data->when(request()->get('name'), function ($query) {
            $name = request()->get('name');
            $query->where('name', "LIKE", "%{$name}%");
        });
        $data->when(request()->get('status'), function ($query) {
            $query->where('status', request()->get('status'));
        });
        $product_types = $data->get();
        return view('admin.attributes.product_type_list', compact('product_types'));
    }

    public function create()
    {
        $route = route('admin.product-types.store');
        return view('admin.attributes.product_type_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('product_types', 'name')->whereNull('deleted_at')
            ],
            'icon' => 'required|mimes:png|max:1024',
            'image' => 'required|image|mimes:jpeg,jpg,png|dimensions:width=750,height=400|max:1024',
            'status' => 'required|in:active,inactive',
        ]);

        $row = new ProductType();
        $row->name = $request->name;
        $row->slug = Str::slug($request->name);
        if ($request->file('icon')) {
            $row->icon = uploadImage($request->file('icon'), 'product_type');
        }
        if ($request->file('image')) {
            $row->image = uploadImage($request->file('image'), 'product_type');
        }
        $row->status = $request->status;
        $row->sorting_serial = ProductType::max('sorting_serial') + 1;
        $row->created_by = Auth::id();
        $row->save();

        return redirect()->route('admin.product-types.index')->with(successMessage());
    }


    public function edit($slug)
    {
        $type = ProductType::whereSlug($slug)->first();
        $route = route('admin.product-types.update', $type->id);
        return view('admin.attributes.product_type_add_edit', compact('type', 'route'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('product_types', 'name')->whereNull('deleted_at')->ignore($id),
            ],
            'icon' => 'nullable|sometimes|mimes:png|max:1024',
            'image' => 'nullable|sometimes|image|mimes:jpeg,jpg,png|dimensions:width=750,height=400|max:1024',
            'status' => 'required|in:active,inactive',
        ]);

        $row = ProductType::findOrFail($id);
        $row->name = $request->name;
        $row->slug = Str::slug($request->name);
        if ($request->file('icon')) {
            if ($row->icon && file_exists($row->icon)) {
                unlink($row->icon);
            }
            $row->icon = uploadImage($request->file('icon'), 'product_type');
        }
        if ($request->file('image')) {
            if ($row->image && file_exists($row->image)) {
                unlink($row->image);
            }
            $row->image = uploadImage($request->file('image'), 'product_type');
        }
        $row->status = $request->status;
        $row->created_by = Auth::id();
        $row->save();

        return redirect()->route('admin.product-types.index')->with(infoMessage());
    }

    public function updateProductTypeStatus($id): \Illuminate\Http\JsonResponse
    {
        $row = ProductType::findOrFail($id);
        // Toggle status between 'active' and 'inactive'
        $row->status = $row->status === 'active' ? 'inactive' : 'active';
        if ($row->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'ProductType status updated successfully.',
            ]);
        }
        // Optional: Handle failure case if needed
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update ProductType status.',
        ], 500);
    }


    public function destroy($id)
    {
        $row = ProductType::findOrFail($id);
        if ($row->image && file_exists($row->image)) {
            unlink($row->image);
        }
        if ($row->icon && file_exists($row->icon)) {
            unlink($row->icon);
        }
        $row->delete();
        return redirect()->route('admin.product-types.index')->with(deleteMessage());
    }

    public function sortProductTypes(Request $request)
    {
        if ($request->has('ids')) {
            $arr = explode(',', $request->input('ids'));

            foreach ($arr as $sortOrder => $id) {
                $row = ProductType::find($id);
                $row->sorting_serial = $sortOrder + 1;
                $row->save();
            }
            return ['success' => true, 'message' => 'Updated'];
        }
    }
}
