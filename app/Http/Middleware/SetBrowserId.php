<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class SetBrowserId
{
    public function handle($request, Closure $next)
    {
        if (!$request->hasCookie('browser_id')) {
            // Set unique browser id
            $browserId = Str::uuid()->toString();
            Cookie::queue('browser_id', $browserId, 60 * 24 * 15); // 15 days
            // Set cart key
            $cartKey = "cart_" . $browserId;
            Cookie::queue('cart_key', $cartKey, 60 * 24 * 15); // 15 days
            // Set price summery key for order
            $priceSummeryKey = "price_summery_" . $browserId;
            Cookie::queue('price_summery_key', $priceSummeryKey, 60 * 24 * 15); // 15 days
        }

        return $next($request);
    }

}

