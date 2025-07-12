<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('user.account.profile', compact('user'));
    }

    public function updateUserProfile(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'district' => 'required|exists:delivery_charges,slug',
            'city' => 'required|max:100',
            'zip_code' => 'required|max:10',
            'address' => 'required|max:255'
        ]);

        $user = Auth::user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->district_id = districtIdBySlug($request->district);
        $user->city = $request->city;
        $user->zip_code = $request->zip_code;
        $user->delivery_address = $request->address;
        $user->save();
        return redirect()->route('user-profile')
                ->with(infoMessage('Information has been updated successfully!'));
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required|max:8',
            'new_password' => 'required|min:6|max:15',
            'confirm_password' => 'required|same:new_password|max:8'
        ]);
        $current_password = $request->current_password;
        $new_password = $request->new_password;
        $running_password = Auth::user()->password;
        if (Hash::check($current_password, $running_password)) {
            Auth::user()->update(['password' => Hash::make($new_password)]);
            return redirect()->route('change-password')
                ->with(infoMessage('Password has been changed successfully!'));
        } else {
            return back()->withErrors(['current_password' => 'The current password you entered is incorrect.']);
        }
    }

    public function updateInitialPassword(Request $request)
    {
        $this->validate($request, [
            'new_password' => 'required|min:6|max:15',
            'confirm_password' => 'required|same:new_password|max:8'
        ]);
        $new_password = $request->new_password;
        Auth::user()->update([
            'password' => Hash::make($new_password),
            'need_change_password' => false
        ]);
        return redirect()->route('change-password')
            ->with(infoMessage('info', 'Password has been changed successfully!'));
    }

    public function updateMobile(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required|min:11|max:11|unique:users,mobile'
        ]);
        Auth::user()->update([
            'mobile' => $request->mobile,
            'need_change_mobile' => false,
            'mobile_verified_at' => null
        ]);
        return redirect()->route('verify-user-mobile')
            ->with(infoMessage('info', 'Mobile number has been changed successfully.Please verify now.'));
    }

    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'mobile' => [
                'required',
                'exists:users,mobile',
                function ($attribute, $value, $fail) {
                    if (Auth::user()->mobile !== $value) {
                        $fail('The mobile number does not matched with you.');
                    }
                }
            ]
        ]);
        // Your logic to send the code here
        $verificationCode = generateVerificationCode();
        // Ensure the verification code is unique by checking if it already exists
        while (User::where('verification_code', $verificationCode)->exists()) {
            $verificationCode = $this->generateVerificationCode(); // Regenerate if exists
        }
        Auth::user()->update([
            'verification_code' => $verificationCode
        ]);
        // Simulate sending the code (use an SMS service here in production)
        // For now, we'll return it for testing purposes
        return response()->json([
            'message' => 'Verification code sent successfully!',
            'code' => $verificationCode
        ]);
    }

    public function verifyMobileCode(Request $request)
    {
        $this->validate($request, [
            'verification_code' => [
                'required',
                'digits:6',
                Rule::exists('users')->where(function ($query) {
                    $query->where('id', Auth::user()->id); // Ensure the verification code belongs to the authenticated admin
                }),
            ]
        ]);

        $user = Auth::user();
        if ($user->verification_code == $request->verification_code) {
            $user->mobile_verified_at = now();
            $user->verification_code = null;
            $user->save();
            return response()->json(['message' => 'Mobile verified successfully!']);
        } else {
            // This will only be reached if the code doesn't match, which is unlikely due to validation
            return response()->json(['error' => 'Invalid verification code!'], 422);
        }
    }

    public function logout()
    {
        Auth::logout();
        // Invalidate the session
        request()->session()->invalidate();
        // Regenerate the CSRF token
        request()->session()->regenerateToken();
        return redirect()->route('home');
    }
}
