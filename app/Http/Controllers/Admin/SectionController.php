<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SectionProduct;
use App\Models\WebPageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SectionController extends Controller
{
    public function sectionList(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $sections = WebPageSection::oldest('sorting_serial')->get();
        return view('admin.sections.section_list', compact('sections'));
    }

    public function addSection(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $route = route('admin.store-section');
        $sorting_serial = WebPageSection::max('sorting_serial') + 1;
        return view('admin.sections.add_edit_section', compact('route', 'sorting_serial'));
    }

    public function storeSection(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'section_title' => 'required|max:50|unique:web_page_sections,section_title',
            'section_for' => 'nullable|sometimes|in:product,category,campaign,advertisement',
            'status' => 'required|in:active,inactive'
        ]);
        $section = new WebPageSection();
        $section->section_slug = Str::slug($request->section_title);
        $section->section_title = $request->section_title;
        $section->section_module = 'custom';
        $section->section_for = $request->section_for ?? 'product';
        $section->status = $request->status;
        $section->sorting_serial = WebPageSection::max('sorting_serial') + 1;
        $section->created_by = Auth::id();
        $section->save();
        return redirect()->route('admin.sections')->with(successMessage());
    }

    public function sortSection(Request $request)
    {
        if ($request->has('ids')) {
            $arr = explode(',', $request->input('ids'));

            foreach ($arr as $sortOrder => $id) {
                $category = WebPageSection::find($id);
                $category->sorting_serial = $sortOrder + 1;
                $category->save();
            }
            return ['success' => true, 'message' => 'Updated'];
        }
    }

    public function editSection($slug): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $section = WebPageSection::whereSectionSlug($slug)->firstOrFail();
        $route = route('admin.update-section', $section->id);
        return view('admin.sections.add_edit_section', compact('section', 'route'));
    }

    public function updateSection(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'section_title' => [
                'required',
                'string',
                'max:50',
                Rule::unique('web_page_sections', 'section_title')->ignore($id, 'id'), // Explicitly specify the column for `ignore()`
            ],
            'section_for' => 'nullable|sometimes|in:product,category,campaign,advertisement',
            'status' => 'required|in:active,inactive',
        ]);

        $section = WebPageSection::findOrFail($id);
        $section->section_slug = Str::slug($request->section_title);
        $section->section_title = $request->section_title;
        if ($section->section_module === 'custom') {
            $section->section_for = $request->section_for ?? 'product';
        }
        $section->status = $request->status;
        $section->sorting_serial = WebPageSection::max('sorting_serial') + 1;
        $section->created_by = Auth::id();
        $section->save();
        return redirect()->route('admin.sections')->with(successMessage());
    }

    public function deleteSection($id): \Illuminate\Http\RedirectResponse
    {
        // Find and delete the section
        $section = WebPageSection::findOrFail($id);
        if ($section->section_module === 'custom') {
            $section->delete();
            // Also delete related products in the SectionProduct table
            SectionProduct::where('section_id', $id)->delete();
            // Reassign sorting_serial for all remaining sections
            $sections = WebPageSection::orderBy('sorting_serial')->get();
            foreach ($sections as $index => $section) {
                $section->update(['sorting_serial' => $index + 1]);
            }
        }
        return redirect()->route('admin.sections')->with(deleteMessage());
    }

    public function updateSectionStatus($id): \Illuminate\Http\JsonResponse
    {
        $category = WebPageSection::findOrFail($id);
        // Toggle status between 'active' and 'inactive'
        $category->status = $category->status === 'active' ? 'inactive' : 'active';
        if ($category->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Section status updated successfully.',
            ]);
        }
        // Optional: Handle failure case if needed
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update category status.',
        ], 500);
    }
}
