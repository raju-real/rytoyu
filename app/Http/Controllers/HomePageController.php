<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    public function home()
    {
//        dd([
//        'browser_id' => request()->cookie('browser_id'),
//        'session_id' => request()->session()->getId(),
//        'cart_key' => request()->cookie('cart_key'),
////        'cart_items' => cartItems()
//    ]);
        return view('user.pages.home');
    }

    public function singleProductInfo($product_id)
    {
        $data = Product::active()->findOrFail($product_id);
        $product['category_name'] = $data->category->name ?? '';
        $product['subcategory'] = $data->subcategory->name ?? '';
        $product['sub_subcategory'] = $data->sub_subcategory->name ?? '';
        $product['brand'] = $data->brand->name ?? '';
        $product['thumbnail_path'] = $data->thumbnail_path ?? '';
        $product['images'] = $data->images;

        $html = view('user.pages.single_product_view', compact('product'))->render();
        return response()->json(['html' => $html, 'product' => $product]);
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
        $this->validate($request,[
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|max:50',
            'mobile' => 'required|max:11',
            'password' => 'required|min:6|max:15',
            'confirm_password' => 'required|same:password',
            'district_id' => 'required',
            'city' => 'required|max:50',
            'zip_code' => 'required|max:20',
            'delivery_address' => 'required|max:500',
        ]);

        return $request;
    }

    public function userLoginPage()
    {
        return view('user.pages.login');
    }

    public function userLogin(Request $request)
    {
        $this->validate($request, ['mobile' => 'required', 'password' => 'required']);
        if (Auth::guard()->attempt(['mobile' => $request->mobile,
            'password' => $request->password, 'status' => 1], $request->remember)) {
            if (Auth::check()) {
                if (!empty(session()->get('current_url'))) {
                    return redirect(session()->get('current_url'));
                } else {
                    return redirect()->route('user.dashboard');
                }
            }
        } else {
            return redirect()->route('login')->with('Mobile Or Password Missmatched');
        }

        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('mobile', 'remember'));
    }
}
