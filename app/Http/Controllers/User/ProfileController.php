<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('user.account.profile',compact('user'));
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
