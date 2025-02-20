<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLogin extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = ['email' => $request->email, 'password' => $request->password, 'status' => 1];
        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            auth()->guard('admin')->user()->update(['last_login_at' => now()]);
            return redirect()->intended(route('admin.dashboard'));
        } else {
            return redirect()->back()->withInput($request->only('email', 'remember'))
                ->with(dangerMessage('danger','Email or Password not matched!'));
        }
    }
}
