<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()->paginate(20);
        return view('admin.attributes.tag_list', compact('tags'));
    }

    public function create()
    {
        $route = route('admin.tags.store');
        return view('admin.attributes.tag_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
         $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('tags', 'name')->whereNull('deleted_at')
            ],
        ]);
        $tag = new Tag();
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name);
        $tag->created_by = Auth::id();
        $tag->save();
        if($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'data' => $tag->name
            ]);
        } else {
            return redirect()->route('admin.tags.index')->with(successMessage());
        }
    }


    public function edit($slug)
    {
        $tag = Tag::whereSlug($slug)->first();
        $route = route('admin.tags.update', $tag->id);
        return view('admin.attributes.tag_add_edit', compact('tag', 'route'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('tags', 'name')->whereNull('deleted_at')->ignore($id),
            ],
        ]);

        $tag = Tag::findOrFail($id);
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name);
        $tag->created_by = Auth::id();
        return redirect()->route('admin.tags.index')->with(infoMessage());
    }


    public function destroy($id)
    {
        Tag::findOrFail($id)->delete();
        return redirect()->route('admin.tags.index')->with(deleteMessage());
    }
}
