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
            // Set search param key for keywords
            $userSearchKey = "user_search_key_" . $browserId;
            Cookie::queue('user_search_key', $userSearchKey, 60 * 24 * 60); // 60 days
        }

        return $next($request);
    }

}

