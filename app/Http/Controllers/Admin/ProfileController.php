<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\SellerShop;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('admin.profile.edit_profile');
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
            ],
            'email' => [
                'required',
                'email',
                'max:30',
                Rule::unique('admins', 'email')->whereNull('deleted_at')->ignore(authAdmin()->id)
            ],
            'mobile' => [
                'required',
                'string',
                'max:11',
                Rule::unique('admins', 'mobile')->whereNull('deleted_at')->ignore(authAdmin()->id)
            ],
            'image' => 'nullable|sometimes|mimes:jpg,jpeg,png|max:1024',
        ]);

        $admin = Admin::find(authAdmin()->id);
        if ($request->file('image')) {
            if ($admin->image !== null and file_exists($admin->image)) {
                unlink($admin->image);
            }
            $admin->image = uploadImage($request->file('image'), 'admin');
        }
        $admin->save();
        return redirect()->route('admin.profile')->with(infoMessage());
    }

    public function shopInfo()
    {
        return view('admin.profile.shop_info');
    }

    public function updateShopInfo(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'shop_name' => [
                'required',
                'string',
                'max:50',
            ],
            'email' => [
                'required',
                'email',
                'max:30',
                Rule::unique('seller_shops', 'email')->ignore(authShopInfo()->id ?? null),
            ],
            'mobile' => [
                'required',
                'string',
                'min:11',
                'max:11',
                Rule::unique('seller_shops', 'mobile')->ignore(authShopInfo()->id ?? null),
            ],
            'phone' => [
                'nullable',
                'sometimes',
                'string',
                'max:20',
                Rule::unique('seller_shops', 'phone')->ignore(authShopInfo()->id ?? null),
            ],
            'start_from' => 'required|date',
            'licence_no' => [
                'nullable',
                'sometimes',
                'string',
                'max:50',
                Rule::unique('seller_shops', 'licence_no')->ignore(authShopInfo()->id ?? null),
            ],
            'address' => 'required|max:255',
            'logo' => 'nullable|sometimes|mimes:jpg,jpeg,png|max:1024',
            'licence_file' => 'nullable|sometimes|mimes:jpg,jpeg,png|max:1024',
        ]);

        // Check if the shop already exists for the authenticated seller
        $shop = SellerShop::firstOrNew(['seller_id' => Auth::id()]);
        $shop->shop_name = $request->shop_name;
        $shop->email = $request->email;
        $shop->mobile = $request->mobile;
        $shop->phone = $request->phone;
        $shop->address = $request->address;
        $shop->start_from = dateFormat($request->start_from, 'Y-m-d');
        $shop->licence_no = $request->licence_no;
        $shop->website_url = $request->website_url;

        if ($request->file('logo')) {
            if ($shop->image !== null and file_exists($shop->image)) {
                unlink($shop->image);
            }
            $shop->logo = uploadImage($request->file('logo'), 'shop');
        }
        if ($request->file('licence_file')) {
            if ($shop->image !== null and file_exists($shop->image)) {
                unlink($shop->image);
            }
            $shop->licence_file = uploadImage($request->file('licence_file'), 'shop');
        }

        $shop->save();
        return redirect()->route('admin.shop-info')->with(infoMessage());
    }

    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'mobile' => [
            'required',
            'exists:admins,mobile',
            function ($attribute, $value, $fail) {
                if (authAdmin()->mobile !== $value) {
                    $fail('The mobile number does not matched with you.');
                }
            }
        ]
        ]);

        // Your logic to send the code here
        $verificationCode = generateVerificationCode();
        // Ensure the verification code is unique by checking if it already exists
        while (Admin::where('verification_code', $verificationCode)->exists()) {
            $verificationCode = $this->generateVerificationCode(); // Regenerate if exists
        }
        $admin = Admin::find(authAdmin()->id);
        $admin->verification_code = $verificationCode;
        $admin->save();
        // Simulate sending the code (use an SMS service here in production)
        // For now, we'll return it for testing purposes
        return response()->json([
            'message' => 'Verification code sent successfully!',
            'code' => $verificationCode
        ]);
    }

    public function verifyCode(Request $request)
    {
        // Validate the incoming request data
        $this->validate($request, [
            'verification_code' => [
                'required',
                'digits:6',
                Rule::exists('admins')->where(function ($query) {
                    $query->where('id', authAdmin()->id); // Ensure the verification code belongs to the authenticated admin
                }),
            ]
        ]);

        $admin = Admin::find(authAdmin()->id);
        // Check if the verification code matches (this is now redundant but can be kept for clarity)
        if ($admin->verification_code == $request->verification_code) {
            $admin->mobile_verified_at = now();
            $admin->verification_code = null;
            $admin->save();
            return response()->json(['message' => 'Mobile verified successfully!']);
        } else {
            // This will only be reached if the code doesn't match, which is unlikely due to validation
            return response()->json(['error' => 'Invalid verification code!'], 422);
        }
    }
}
