<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\Color;

class CacheCartController extends Controller
{
    protected string|array $cartKey;
    protected string|array $priceSummeryKey;

    public function __construct()
    {
        $this->cartKey = $this->getCartKey();
        $this->priceSummeryKey = $this->getPriceSummeryKey();
    }

    protected function getCartKey(): array|string
    {
        return request()->cookie('cart_key') ?? 'default_cart_key';
    }

    protected function getPriceSummeryKey(): array|string
    {
        return request()->cookie('price_summery_key') ?? 'default_price_summery_key';
    }

    protected function generateCartItemKey($productId, $sizeId = null, $colorId = null): string
    {
        return $productId . '_' . ($sizeId ?? 'default') . '_' . ($colorId ?? 'default');
    }

    protected function getCartItemsRaw()
    {
        return Cache::get($this->cartKey, []);
    }

    protected function saveCartItems(array $items): void
    {
        Cache::put($this->cartKey, $items, now()->addDays(15));
    }

    public function addToCart(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'size_id' => 'nullable|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
        }

        $productId = $request->product_id;
        $sizeId = $request->size_id;
        $colorId = $request->color_id;
        $quantity = $request->quantity;
        $product = Product::findOrFail($productId);

        $variant = ProductVariant::where('product_id', $productId)
            ->when($sizeId, fn($q) => $q->where('size_id', $sizeId))
            ->when($colorId, fn($q) => $q->where('color_id', $colorId))
            ->first();

        if (!$variant) {
            return response()->json(['status' => 'error', 'message' => 'Product variant not found.']);
        }

        $cartItems = $this->getCartItemsRaw();
        $itemKey = $this->generateCartItemKey($productId, $sizeId, $colorId);
        $price = $variant->discount_price > 0 ? $variant->discount_price : $variant->unit_price;

        if (isset($cartItems[$itemKey])) {
            $cartItems[$itemKey]['quantity'] += $quantity;
        } else {
            $cartItems[$itemKey] = [
                'product_id' => $productId,
                'product_name' => $product->name,
                'variant_id' => $variant->id,
                'size_id' => $sizeId,
                'color_id' => $colorId,
                'item_price' => $price,
                'quantity' => $quantity,
            ];
        }

        $cartItems[$itemKey]['order_price'] = $cartItems[$itemKey]['item_price'] * $cartItems[$itemKey]['quantity'];
        $this->saveCartItems($cartItems);
        return response()->json(['status' => 'success', 'message' => 'Item added to cart.']);
    }

    public function getCartItems(): array
    {
        $cartItems = $this->getCartItemsRaw();
        $cartItemsArray = collect($cartItems)->map(function ($item, $itemKey) {
            $product = Product::select('id', 'name', 'slug', 'thumbnail_path')->find($item['product_id']);
            $size = $item['size_id'] ? Size::find($item['size_id']) : null;
            $color = $item['color_id'] ? Color::find($item['color_id']) : null;
            return [
                'item_key' => $itemKey, // Important: Attach item_key here
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'item_price' => $item['item_price'],
                'order_price' => $item['item_price'] * $item['quantity'],
                'product_slug' => $product?->slug ?? '',
                'product_thumbnail' => $product?->thumbnail_path ?? '',
                'size_name' => $size?->name ?? null,
                'color_name' => $color?->name ?? null,
            ];
        });
        $itemTotal = $cartItemsArray->sum('order_price');
        return [
            'item_total' => $itemTotal,
            'total_price' => $itemTotal,
            'items' => $cartItemsArray->values(),
        ];
    }


    public function loadCartItems(): array
    {
        $cart_items = $this->getCartItems();
        return [
            'item_summary' => $cart_items,
            'html' => view('user.pages.cart_items', compact('cart_items'))->render(),
        ];
    }

    public function getPriceSummery()
    {
        $this->applyCoupon();
        $price_summery_key = $this->priceSummeryKey;
        $cart_items = $this->getCartItems();

        $total_item_price = $cart_items['item_total'];
        $shipping_fee = shippingFee(); // example fixed shipping fee
        $item_total_discount = 0;
        $applied_coupon = null;
        $coupon_discount = 0;

        // If you have discount logic or applied coupon, you can set here:
        if (session()->has('applied_coupon_code')) {
            $applied_coupon = session('applied_coupon_code');
            $coupon_discount = session('applied_coupon_discount');
        }

        $total_discount = $item_total_discount + $coupon_discount;
        $total_order_price = ($total_item_price + $shipping_fee) - $coupon_discount;

        $price_summary = [
            'total_item_price' => $total_item_price,
            'shipping_fee' => $shipping_fee,
            'total_order_price' => $total_order_price,
            'item_total_discount' => $item_total_discount,
            'applied_coupon' => $applied_coupon,
            'coupon_discount' => $coupon_discount,
            'total_discount' => $total_discount
        ];
        // Save into cookie
        cookie()->queue(cookie($price_summery_key, json_encode($price_summary), 60 * 24 * 7)); // 7 days
        return $price_summary;
    }

    public function loadPriceSummery()
    {
        $price_summery = $this->getPriceSummery();
        return [
            'html' => view('user.pages.checkout_summery', compact('price_summery'))->render()
        ];
    }

    public function applyCoupon()
    {
        $coupon_code = 'DUMMY10';
        $discount = 100;
        // **** Coupon apply logic here ///
        // Store coupon in session
        session(['applied_coupon_code' => $coupon_code]);
        session(['applied_coupon_discount' => $discount]);
        // Recalculate price summery
//        $this->getPriceSummery();
//        return response()->json([
//            'message' => 'Coupon applied successfully.',
//            'coupon' => $coupon
//        ]);
    }


    public function updateCartQuantity(Request $request): JsonResponse
    {
        $itemKey = $request->item_key;
        $action = $request->action;
        // Get the current cart items
        $cartItems = $this->getCartItemsRaw();
        if (!isset($cartItems[$itemKey])) {
            return response()->json(['status' => 'error', 'message' => 'Item not found in cart.']);
        }
        // Get the current quantity and update it based on action
        $currentQuantity = $cartItems[$itemKey]['quantity'];
        if ($action == 'increase') {
            $newQuantity = $currentQuantity + 1;
        } elseif ($action == 'decrease' && $currentQuantity > 1) {
            $newQuantity = $currentQuantity - 1;
        } else {
            return response()->json(['status' => 'error', 'message' => 'Invalid action or quantity is too low to decrease.']);
        }
        // Update the quantity in the cart
        $cartItems[$itemKey]['quantity'] = $newQuantity;
        // Save the updated cart
        $this->saveCartItems($cartItems);
        return response()->json(['status' => 'success', 'message' => 'Cart updated successfully.']);
    }


    public function removeFromCart(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|string',
        ]);
        $cartItems = $this->getCartItemsRaw();
        $removedCount = 0;
        foreach ($request->ids as $itemKey) {
            if (isset($cartItems[$itemKey])) {
                unset($cartItems[$itemKey]);
                $removedCount++;
            }
        }
        $this->saveCartItems($cartItems);
        if ($removedCount > 0) {
            return response()->json(['status' => 'success', 'message' => 'Selected item(s) removed from cart.']);
        }
        return response()->json(['status' => 'error', 'message' => 'No matching items found in cart.']);
    }

    public function getCheckoutProducts(): JsonResponse
    {
        $cartItems = $this->getCartItems(); // your method to fetch cart data
        $cart_item_view = view('user.pages.checkout_items', ['cart_items' => $cartItems])->render();
        return response()->json([
            'html' => $cart_item_view
        ]);
    }

    public function clearCart(): JsonResponse
    {
        Cache::forget($this->cartKey);
        return response()->json(['status' => 'success', 'message' => 'Cart cleared.']);
    }

    public function checkout()
    {
        if (Auth::check()) {
            $cart_items = $this->getCartItems();
            return view('user.pages.checkout', compact('cart_items'));
        } else {
            session()->put('current_url', URL::current());
            return redirect()->route('login');
        }
    }

    public function submitOrder(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'address' => 'required|max:255',
            'country' => 'nullable|max:100',
            'city' => 'nullable|max:100',
            'zip_code' => 'required|max:10',
            'email' => 'required|email|max:50',
            'mobile' => 'required|max:20',
            'additional_information' => 'nullable|max:500',
        ]);

        // Your order logic here...

        return response()->json(['status' => 'success', 'message' => 'Order submitted successfully.']);
    }
}
