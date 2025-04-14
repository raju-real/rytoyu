<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\SliderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SliderController extends Controller
{
    public function index()
    {
        $data = Slider::query();
        $data->sort();
        $data->when(request()->get('search'), function ($query) {
            $search = request()->get('search');
            $query->where('title', "LIKE", "%{$search}%");
            $query->orWhere('highlighted_title', "LIKE", "%{$search}%");
            $query->orWhere('caption', "LIKE", "%{$search}%");
            $query->orWhere('highlighted_caption', "LIKE", "%{$search}%");
        });
        $data->when(request()->get('status'), function ($query) {
            $query->where('status', request()->get('status'));
        });
        $sliders = $data->paginate(100);
        return view('admin.sections.slider_list', compact('sliders'));
    }

    public function create()
    {
        $route = route('admin.sliders.store');
        return view('admin.sections.slider_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:100',
            'highlighted_title' => 'required|string|max:100',
            'caption' => 'required|string|max:100',
            'highlighted_caption' => 'required|string|max:100',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:5120|dimensions:width=1440,height=540',
            'button_name' => 'nullable|sometimes|string|max:50',
            'redirect_link' => 'nullable|sometimes|string|url|max:350',
            'status' => 'required|in:active,inactive'
        ]);

        $slider = new Slider();
        $slider->title = $request->title ?? null;
        $slider->highlighted_title = $request->highlighted_title ?? null;
        $slider->caption = $request->caption ?? null;
        $slider->highlighted_caption = $request->highlighted_caption ?? null;
        $slider->slug = time() . '-' . Str::slug($request->title);
        if ($request->file('image')) {
            $slider->image_path = uploadImage($request->file('image'), 'slider');
        }
        $slider->button_name = $request->button_name ?? 'Shop Now';
        $slider->redirect_link = $request->redirect_link;
        $slider->status = $request->status;
        $slider->sorting_serial = Slider::max('sorting_serial') + 1;
        $slider->created_by = Auth::id();
        $slider->save();
        return redirect()->route('admin.sliders.index')->with(successMessage());
    }


    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        $route = route('admin.sliders.update', $slider->id);
        return view('admin.sections.slider_add_edit', compact('slider', 'route'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string|max:100',
            'highlighted_title' => 'required|string|max:100',
            'caption' => 'required|string|max:100',
            'highlighted_caption' => 'required|string|max:100',
            'image' => 'nullable|sometimes|image|mimes:jpg,jpeg,png|max:5120|dimensions:width=1440,height=540',
            'button_name' => 'nullable|sometimes|string|max:50',
            'redirect_link' => 'nullable|sometimes|string|url|max:350',
            'status' => 'required|in:active,inactive'
        ]);

        $slider = Slider::findOrFail($id);
        $slider->title = $request->title ?? null;
        $slider->highlighted_title = $request->highlighted_title ?? null;
        $slider->caption = $request->caption ?? null;
        $slider->highlighted_caption = $request->highlighted_caption ?? null;
        $slider->slug = time() . '-' . Str::slug($request->title);
        if ($request->file('image')) {
            $slider->image_path = uploadImage($request->file('image'), 'slider');
        }
        $slider->button_name = $request->button_name ?? 'Shop Now';
        $slider->redirect_link = $request->redirect_link;
        $slider->status = $request->status;
        $slider->sorting_serial = Slider::max('sorting_serial') + 1;
        $slider->created_by = Auth::id();
        $slider->save();
        return redirect()->route('admin.sliders.index')->with(infoMessage());
    }

    public function updateSliderStatus($id): \Illuminate\Http\JsonResponse
    {
        $slider = Slider::findOrFail($id);
        // Toggle status between 'active' and 'inactive'
        $slider->status = $slider->status === 'active' ? 'inactive' : 'active';
        if ($slider->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Slider status updated successfully.',
            ]);
        }
        // Optional: Handle failure case if needed
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update slider status.',
        ], 500);
    }


    public function destroy($id)
    {
        $slider = Slider::findOrFail($id)->delete();
        if (!empty($slider->image_path) and file_exists($slider->image_path)) {
            unlink($slider->image_path);
        }
        SliderProduct::whereIn('slider_id', [$id])->delete();
        return redirect()->route('admin.sliders.index')->with(deleteMessage());
    }

    public function sortSliders(Request $request)
    {
        if ($request->has('ids')) {
            $arr = explode(',', $request->input('ids'));

            foreach ($arr as $sortOrder => $id) {
                $row = Slider::find($id);
                $row->sorting_serial = $sortOrder + 1;
                $row->save();
            }
            return ['success' => true, 'message' => 'Updated'];
        }
    }

    // Slider product section
    public function sliderProducts($slider_id)
    {
        $slider = Slider::findOrFail($slider_id);
        $slider_products = SliderProduct::where('slider_id', $slider_id)->get();
        return view('admin.sections.slider_products', compact('slider_products', 'slider'));
    }

    public function getSliderWiseProducts($slider_id)
    {
        $sectionProducts = SliderProduct::with([
            'product' => function ($product) {
                $product->select('id', 'seller_id', 'product_code', 'name', 'thumbnail_path');
            }
        ])
            ->where('slider_id', $slider_id)
            ->orderBy('sorting_serial')
            ->get();

        return response()->json($sectionProducts);
    }

    public function addSliderProduct(Request $request)
    {
        // Validate input
        $request->validate([
            'slider_id' => [
                'required',
                Rule::exists('sliders', 'id'),
            ],
            'product_id' => [
                'required',
                Rule::exists('products', 'id'),
            ],
        ]);

        $sliderId = $request->slider_id;
        $productId = $request->product_id;

        // Check if the product already exists in the slider
        $exists = SliderProduct::where('slider_id', $sliderId)
            ->where('product_id', $productId)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Product already exists in this slider!',
            ], 400);
        }

        // Get the max sorting serial for the slider
        $maxSortingSerial = SliderProduct::where('slider_id', $sliderId)->max('sorting_serial') ?? 0;

        // Add the product to the slider
        SliderProduct::create([
            'slider_id' => $sliderId,
            'product_id' => $productId,
            'sorting_serial' => $maxSortingSerial + 1,
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'Product added successfully to the slider!',
        ]);
    }

    public function deleteSliderProduct()
    {
        $slider_id = request()->get('slider_id');
        $product_id = request()->get('product_id');
        $deleted = SliderProduct::where('product_id', $product_id)
            ->where('slider_id', $slider_id)
            ->delete();

        if ($deleted) {
            // Reassign sorting_serial for all remaining sliders
            $sliders = SliderProduct::where('slider_id', $slider_id)->orderBy('sorting_serial')->get();
            foreach ($sliders as $index => $section) {
                $section->update(['sorting_serial' => $index + 1]);
            }
            return response()->json(['status' => 'success', 'message' => 'Product deleted successfully!']);
        }

        return response()->json(['status' => 'error', 'message' => 'Failed to delete product.'], 500);
    }

    public function updateSliderProductSorting(Request $request)
    {
        if ($request->has('ids')) {
            $arr = $request->input('ids');
            foreach ($arr as $sortOrder => $id) {
                $row = SliderProduct::find($id);
                $row->sorting_serial = $sortOrder + 1;
                $row->save();
            }
            return ['success' => true, 'message' => 'Updated'];
        }
    }
}
