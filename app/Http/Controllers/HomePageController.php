<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\SliderProduct;
use App\Models\SubCategory;
use App\Models\SubSubcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class HomePageController extends Controller
{
    public function home()
    {
        return view('user.pages.home');
    }

    public function searchProduct()
    {
        $searchParam = request()->get('search');
        if (!$searchParam) return redirect()->back();
        // Track search
        trackUserSearchKeyword($searchParam);
        // Search products
        $products = Product::whereRaw("MATCH(name) AGAINST (? IN BOOLEAN MODE)", [$searchParam])->paginate(30);
        return view('user.pages.products', compact('products', 'searchParam'));
    }

    public function products()
    {
        $heading_title = '';
        $banner_images = [];
        $data = Product::query();
        // Slider wise products
        if (request()->has('slider')) {
            $slider_slug = request()->get('slider');
            $slider = Slider::whereSlug($slider_slug)->firstOrFail();
            $slider_products = SliderProduct::where('slider_id', $slider->id)->pluck('product_id')->toArray();
            $data->whereIn('id', $slider_products);
            $heading_title = $slider->title;
        }
        // User search
        if (request()->has('search')) {
            $searchParam = request()->get('search');
            if (!$searchParam) return redirect()->back();
            trackUserSearchKeyword($searchParam); // Track search
            $data->whereRaw("MATCH(name) AGAINST (? IN BOOLEAN MODE)", [$searchParam]);
            $heading_title = "Search Results for " . $searchParam;
            // Search param set on session
            $searchKey = 'user_search_key_' . request()->cookie('browser_id');
            session(['user_search_key' => $searchKey]);
            session(['search_keywords_' . $searchKey => explode(' ', $searchParam)]);
        }
        // Searches from page on filterd
        if (request()->has('search_on')) {
            $searchParam = request()->get('search_on');
            if (!$searchParam) return redirect()->back();
            $data->whereRaw("MATCH(name) AGAINST (? IN BOOLEAN MODE)", [$searchParam]);
        }
        // Category wise products
        if (request()->has('category')) {
            $category_slug = request()->get('category');
            $category = Category::whereSlug($category_slug)->firstOrFail();
            $data->where('category_id', $category->id);
            $heading_title = $category->name;
            $banner_images = $category->banner_images->pluck('image')->toArray();
        }

        // Sub Category wise products
        if (request()->has('subcategory')) {
            $subcategory_slug = request()->get('subcategory');
            $subcategory = SubCategory::whereSlug($subcategory_slug)->firstOrFail();
            $data->where('subcategory_id', $subcategory->id);
            $heading_title = $subcategory->name;
            $banner_images = $subcategory->banner_images->pluck('image')->toArray();
        }

        // Sub SubCategory wise products
        if (request()->has('sub_subcategory')) {
            $sub_subcategory_slug = request()->get('sub_subcategory');
            $sub_subcategory = SubSubcategory::whereSlug($sub_subcategory_slug)->firstOrFail();
            $data->where('sub_subcategory_id', $sub_subcategory->id);
            $heading_title = $sub_subcategory->name;
            $banner_images = $sub_subcategory->banner_images->pluck('image')->toArray();
        }

        // Brand wise products
        if (request()->has('brand')) {
            $brand_slug = request()->get('brand');
            $brand = Brand::whereSlug($brand_slug)->firstOrFail();
            $data->where('brand_id', $brand->id);
            $heading_title = $brand->name;
            $banner_images = $brand->banner_images->pluck('image')->toArray();
        }

        // Amount Max
        if (request()->has('amount_max')) {
            $amount_max = request()->get('amount_max');
            $data->whereRaw('
            CASE
                WHEN discount_price > 0 THEN discount_price
                ELSE unit_price
            END <= ?', [$amount_max]);
        }

        // Amount Min
        if (request()->has('amount_min')) {
            $amount_min = request()->get('amount_min');
            $data->whereRaw('
            CASE
                WHEN discount_price > 0 THEN discount_price
                ELSE unit_price
            END >= ?', [$amount_min]);
        }

        $products = $data->paginate(30);
        //return view('user.pages.products', compact('products', 'heading_title', 'banner_images'));
        return view('user.pages.products', compact('products', 'heading_title', 'banner_images'));
    }


    public function singleProductInfo($product_id)
    {
        $product = Product::active()->findOrFail($product_id);

        $html = view('user.pages.single_product_view', compact('product'))->render();
        return response()->json(['html' => $html]);
    }

    public function productDetails($slug = null)
    {
        $product = Product::whereSlug($slug)->firstOrFail();
        //return $product;
        $related_products = Product::where('category_id', $product->category_id)->inRandomOrder()->take(16)->get();
        return view('user.pages.product_details', compact('product', 'related_products'));
    }

    // Authentication Part
    public function userRegisterPage()
    {
        return view('user.pages.register');
    }

    public function userRegistration(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'mobile' => [
                'required',
                'min:11',
                'max:11',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'password' => 'required|min:6|max:15',
            'confirm_password' => 'required|same:password',
            'district_id' => 'required',
            'city' => 'required|max:50',
            'zip_code' => 'required|max:10',
            'delivery_address' => 'required|max:500',
        ]);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = Hash::make($request->password);
        $user->district_id = $request->district_id ?? null;
        $user->city = $request->city ?? null;
        $user->zip_code = $request->zip_code ?? null;
        $user->home_address = $request->home_address ?? null;
        $user->delivery_address = $request->delivery_address ?? null;
        $user->save();
        return redirect()->route('home');
    }

    public function userLoginPage()
    {
        return view('user.pages.login');
    }

    public function userLogin(Request $request)
    {
        Auth::logout();
        $this->validate($request, [
            'email_or_mobile' => 'required',
            'password' => 'required'
        ]);

        if (is_numeric($request->get('email_or_mobile'))) {
            $credential = [
                'mobile' => $request->get('email_or_mobile'),
                'password' => $request->get('password')
            ];
        } elseif (filter_var($request->get('email_or_mobile'), FILTER_VALIDATE_EMAIL)) {
            $credential = [
                'email' => $request->get('email_or_mobile'),
                'password' => $request->get('password'),
            ];
        }
        $credential['status'] = 'active';

        if (Auth::guard()->attempt($credential, $request->remember)) {
            if (Auth::check()) {
                if (!empty(session()->get('current_url'))) {
                    return Redirect::to(session('current_url'));
                } else {
                    return redirect()->intended(route('user-profile'));
                }
            }
        }

        return redirect()->back()
            ->with('message', 'Invalid Credentials!')
            ->withInput($request->only('mobile', 'remember'));
    }
}
