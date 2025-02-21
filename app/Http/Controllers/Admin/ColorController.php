<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::latest()->paginate(20);
        return view('admin.attributes.color_list', compact('colors'));
    }

    public function create()
    {
        $route = route('admin.colors.store');
        return view('admin.attributes.color_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('colors', 'name')->whereNull('deleted_at')
            ],
            'color_code' => [
                'required',
                'string',
                'max:50'
            ],
        ]);
        $color = new Color();
        $color->name = $request->name;
        $color->color_code = $request->color_code;
        $color->slug = Str::slug($request->name);
        $color->created_by = Auth::id();
        $color->save();
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'data' => $color
            ]);
        } else {
            return redirect()->route('admin.colors.index')->with(successMessage());
        }
    }


    public function edit($slug)
    {
        $color = Color::whereSlug($slug)->first();
        $route = route('admin.colors.update', $color->id);
        return view('admin.attributes.color_add_edit', compact('color', 'route'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('colors', 'name')->whereNull('deleted_at')->ignore($id),
            ],
            'color_code' => [
                'required',
                'string',
                'max:50',
            ],
        ]);

        $color = Color::findOrFail($id);
        $color->name = $request->name;
        $color->color_code = $request->color_code;
        $color->slug = Str::slug($request->name);
        $color->created_by = Auth::id();
        $color->save();
        return redirect()->route('admin.colors.index')->with(infoMessage());
    }


    public function destroy($id)
    {
        Color::findOrFail($id)->delete();
        return redirect()->route('admin.colors.index')->with(deleteMessage());
    }
}
