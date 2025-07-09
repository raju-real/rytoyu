<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->paginate(20);
        return view('admin.settings.faq_list', compact('faqs'));
    }

    public function create()
    {
        $route = route('admin.faqs.store');
        return view('admin.settings.faq_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'question' => 'required|string|max:100',
            'answer' => 'required|string|max:2000',
        ]);
        $faq = new Faq();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();
        return redirect()->route('admin.faqs.index')->with(successMessage());
    }


    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $route = route('admin.faqs.update', $faq->id);
        return view('admin.settings.faq_add_edit', compact('faq', 'route'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'question' => 'required|string|max:100',
            'answer' => 'required|string|max:2000',
        ]);
        $faq = Faq::findOrFail($id);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();
        return redirect()->route('admin.faqs.index')->with(infoMessage());
    }


    public function destroy($id)
    {
        Faq::findOrFail($id)->delete();
        return redirect()->route('admin.faqs.index')->with(deleteMessage());
    }
}
