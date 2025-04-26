<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(20);
        return view('admin.sections.announcement_list', compact('announcements'));
    }

    public function create()
    {
        $route = route('admin.announcements.store');
        return view('admin.sections.announcement_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
         $this->validate($request, [
            'title' => 'required|string|max:255',
            'highlighted_title' => 'required|string|max:100'
        ]);
        $row = new Announcement();
        $row->title = $request->title;
        $row->highlighted_title = $request->highlighted_title;
        $row->created_by = Auth::id();
        $row->save();
        return redirect()->route('admin.announcements.index')->with(successMessage());
    }


    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        $route = route('admin.announcements.update', $id);
        return view('admin.sections.announcement_add_edit', compact('announcement', 'route'));
    }


    public function update(Request $request, $id)
    {
       $this->validate($request, [
            'title' => 'required|string|max:255',
            'highlighted_title' => 'required|string|max:100'
        ]);
        $row = Announcement::findOrFail($id);
        $row->title = $request->title;
        $row->highlighted_title = $request->highlighted_title;
        $row->created_by = Auth::id();
        $row->save();
        return redirect()->route('admin.announcements.index')->with(infoMessage());
    }


    public function destroy($id)
    {
        Announcement::findOrFail($id)->delete();
        return redirect()->route('admin.announcements.index')->with(deleteMessage());
    }
}
