<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Category;
use App\Models\JoinRequest;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Review;
use App\Models\Slider;
use App\Models\SliderProduct;
use App\Models\SubCategory;
use App\Models\SubSubcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        trackUserSearchKeyword($searchParam);   // Track search
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
        // Type wise products
        if (request()->has('type')) {
            $type_slug = request()->get('type');
            $product_type = ProductType::whereSlug($type_slug)->firstOrFail();
            $data->where('product_type_id', $product_type->id);
            $heading_title = $product_type->name;
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
        $related_products = Product::where('category_id', $product->category_id)->inRandomOrder()->take(16)->get();
        $reviews = Review::where('product_id',$product->id)->paginate(50);
        return view('user.pages.product_details', compact('product', 'related_products','reviews'));
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

    public function sellerRegister(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => [
                'required',
                'email',
                'max:30',
                Rule::unique('admins')->whereNull('deleted_at'),
            ],
            'mobile' => [
                'required',
                'min:11',
                'max:11',
                Rule::unique('admins')->whereNull('deleted_at'),
            ],
            'password' => 'required|min:6|max:15'
        ]);

        $seller = new Admin();
        $seller->type = 'seller';
        $seller->code = Admin::getCode();
        $seller->name = $request->name;
        $seller->email = $request->email;
        $seller->mobile = $request->mobile;
        $seller->password_plain = $request->password;
        $seller->password = Hash::make($request->password);
        $seller->status = 'inactive';
        $seller->request_status = 'pending';
        $seller->save();
        return redirect()->route('seller-registration-form')->with('message','Thanks for registering! Our admin team will get in touch with you as soon as possible.');
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

    public function sendJoinRequest(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|max:50',
            'mobile' => 'required|max:11',
            'curriculum_vitae' => 'required|mimes:pdf|max:5120'
        ]);

        $row = new JoinRequest();
        $row->name = $request->name;
        $row->email = $request->email;
        $row->mobile = $request->mobile;
        if ($request->file('curriculum_vitae')) {
            $row->cv_path = uploadFile($request->file('curriculum_vitae'), 'curriculum_vitae');
        }
        $row->save();
        return redirect()->route('join-request')->with('message','Your request has been sent successfully! Our admin team will get in touch with you as soon as possible.');
    }


    public function sendContactMessage(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|max:50',
            'mobile' => 'required|max:20',
            'message' => 'required|max:1000'
        ]);
        $mail_data = [
            'subject' => $request->name . ' wants to contact with you',
            'body' => $request->message,
            'title' => 'Someone wants to contact with you.',
            'mobile' => $request->mobile,
            'name' => $request->name,
            'email' => $request->email
        ];

        try {
            $mailSent = Mail::to(siteSettings()['company_email'])->send(new SendMail($mail_data));

            if (!$mailSent) {
                return redirect()->route("contact")->with(['type' => 'success', 'message' => 'Message not sent. Something went wrong!']);
            } else {
                return redirect()->route("contact")->with(['type' => 'info', 'message' => 'Your message has been sent successfully.']);
            }
        } catch (\Exception $e) {
            return redirect()->route("contact")->with(['type' => 'danger', 'message' => 'Message not sent. Something went wrong!']);
        }

    }

}
