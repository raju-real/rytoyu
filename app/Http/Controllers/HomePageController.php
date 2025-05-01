<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
         //return getUserSearchProducts();
        return view('user.pages.home');
    }

    public function searchProduct()
    {
        $searchParam = request()->get('search');
        if (!$searchParam) return redirect()->back();

        // Track search
        trackUserSearchKeyword($searchParam);

        // Search products
        return $products = Product::whereRaw("MATCH(name) AGAINST (? IN BOOLEAN MODE)", [$searchParam])->get();

        return view('user.pages.search-result', compact('products', 'searchParam'));
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
