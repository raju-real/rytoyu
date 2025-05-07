<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    /**
     * Login Using Facebook
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        try {
            $fb_user = Socialite::driver('facebook')->user();
            if (User::where('email', $fb_user->getEmail())->exists()) {
                $user = User::where('email', $fb_user->getEmail())->first();
                $user->save();
                $user_id = $user->id;
                Auth::loginUsingId($user_id);
            } else {
                $identify = ['facebook_id' => $fb_user->getId()];
                $data = [
                    'first_name' => explode(' ', $fb_user->getName())[0],
                    'last_name' => explode(' ', $fb_user->getName())[1],
                    'email' => $fb_user->getEmail(),
                    'mobile' => 'google' . mt_rand(10000, 99999),
                    'facebook_id' => $fb_user->getId(),
                    'password' => Hash::make(substr(md5(uniqid(random_int(0, 50), true)), 0, 6)),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'need_change_mobile' => true,
                    'need_change_password' => true,
                ];
                User::updateOrInsert($identify, $data);
                $fb_user_id = User::where('email', $fb_user->getEmail())->first()->id;
                Auth::loginUsingId($fb_user_id);
            }

            if (Auth::check()) {
                if (!empty(session()->get('current_url'))) {
                    return Redirect::to(session('current_url'));
                } else {
                    return redirect()->intended(route('user-profile'));
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function googleCallback()
    {
        try {
            $g_user = Socialite::driver('google')->stateless()->user();
            //dd($g_user);
            if (User::where('email', $g_user->email)->exists()) {
                $user = User::where('email', $g_user->email)->first();
                $user->email_verified_at = now();
                $user->save();
                $user_id = $user->id;
                Auth::loginUsingId($user_id);
            } else {
                $identify = array('google_id' => $g_user->id, 'email' => $g_user->email);
                $data = [
                    'first_name' => explode(' ', $g_user->name)[0] ?? 'Name',
                    'last_name' => explode(' ', $g_user->name)[1] ?? 'Name',
                    'email' => $g_user->email,
                    'mobile' => 'google' . mt_rand(10000, 99999),
                    'google_id' => $g_user->id,
                    'password' => Hash::make(substr(md5(uniqid(random_int(0, 50), true)), 0, 6)),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'need_change_mobile' => true,
                    'need_change_password' => true,
                ];
                User::updateOrInsert($identify, $data);
                $g_user_id = User::where('email', $g_user->email)->first()->id;
                Auth::loginUsingId($g_user_id);
            }
            if (Auth::check()) {
                if (!empty(session()->get('current_url'))) {
                    return Redirect::to(session('current_url'));
                } else {
                    return redirect()->intended(route('user-profile'));
                }
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
