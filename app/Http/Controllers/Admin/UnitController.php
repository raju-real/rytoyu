<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::latest()->paginate(20);
        return view('admin.attributes.unit_list', compact('units'));
    }

    public function create()
    {
        $route = route('admin.units.store');
        return view('admin.attributes.unit_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
         $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('units', 'name')->whereNull('deleted_at')
            ],
        ]);
        $unit = new Unit();
        $unit->name = $request->name;
        $unit->slug = Str::slug($request->name);
        $unit->created_by = Auth::id();
        $unit->save();
        if($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'data' => $unit
            ]);
        } else {
            return redirect()->route('admin.units.index')->with(successMessage());
        }
    }


    public function edit($slug)
    {
        $unit = Unit::whereSlug($slug)->first();
        $route = route('admin.units.update', $unit->id);
        return view('admin.attributes.unit_add_edit', compact('unit', 'route'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('units', 'name')->whereNull('deleted_at')->ignore($id),
            ],
        ]);

        $unit = Unit::findOrFail($id);
        $unit->name = $request->name;
        $unit->slug = Str::slug($request->name);
        $unit->created_by = Auth::id();
        return redirect()->route('admin.units.index')->with(infoMessage());
    }


    public function destroy($id)
    {
        Unit::findOrFail($id)->delete();
        return redirect()->route('admin.units.index')->with(deleteMessage());
    }
}
