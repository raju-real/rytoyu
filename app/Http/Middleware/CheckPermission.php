<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if (\Illuminate\Support\Facades\Auth::guard('admin')->check()) {
            if (\Illuminate\Support\Facades\Auth::guard('admin')->user()->hasPermissionTo($permission)) {
                return $next($request);
            }
        }

        return redirect()->route('admin.permission-denied');
    }
}
