<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::latest()->paginate(20);
        return view('admin.attributes.size_list', compact('sizes'));
    }

    public function create()
    {
        $route = route('admin.sizes.store');
        return view('admin.attributes.size_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
         $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('sizes', 'name')->whereNull('deleted_at')
            ],
        ]);
        $size = new Size();
        $size->name = $request->name;
        $size->slug = Str::slug($request->name);
        $size->created_by = Auth::id();
        $size->save();
        if($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'data' => $size
            ]);
        } else {
         return redirect()->route('admin.sizes.index')->with(successMessage());
        }
    }


    public function edit($slug)
    {
        $size = Size::whereSlug($slug)->first();
        $route = route('admin.sizes.update', $size->id);
        return view('admin.attributes.size_add_edit', compact('size', 'route'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('sizes', 'name')->whereNull('deleted_at')->ignore($id),
            ],
        ]);

        $size = Size::findOrFail($id);
        $size->name = $request->name;
        $size->slug = Str::slug($request->name);
        $size->created_by = Auth::id();
        return redirect()->route('admin.sizes.index')->with(infoMessage());
    }


    public function destroy($id)
    {
        Size::findOrFail($id)->delete();
        return redirect()->route('admin.sizes.index')->with(deleteMessage());
    }
}
