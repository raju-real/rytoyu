<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductVariant;

class CacheCartController extends Controller
{
    protected $cartKey;

    public function __construct()
    {
        $this->cartKey = $this->getCartKey();
    }

    protected function getCartKey()
    {
        return request()->cookie('cart_key');
    }

    protected function generateCartItemKey($productId, $sizeId = null, $colorId = null)
    {
        return $productId . '_' . ($sizeId ?? 'default') . '_' . ($colorId ?? 'default');
    }

    protected function productExistsInCart($productId, $sizeId = null, $colorId = null)
    {
        $cartItems = Cache::get($this->cartKey, []);
        $key = $this->generateCartItemKey($productId, $sizeId, $colorId);
        return $cartItems[$key] ?? null;
    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'size_id' => 'nullable|integer',
            'color_id' => 'nullable|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
        }

        $productId = $request->product_id;
        $sizeId = $request->size_id;
        $colorId = $request->color_id;
        $quantity = $request->quantity;

        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found']);
        }

        $variant = ProductVariant::where('product_id', $productId)
            ->when($sizeId, fn($q) => $q->where('size_id', $sizeId))
            ->when($colorId, fn($q) => $q->where('color_id', $colorId))
            ->first();

        if (!$variant) {
            return response()->json(['status' => 'error', 'message' => 'Variant not found']);
        }

        $cartItems = Cache::get($this->cartKey, []);
        $itemKey = $this->generateCartItemKey($productId, $sizeId, $colorId);
        if (isset($cartItems[$itemKey])) {
            $cartItems[$itemKey]['quantity'] += $quantity;
            $cartItems[$itemKey]['order_price'] = $cartItems[$itemKey]['item_price'] * $cartItems[$itemKey]['quantity'];
        } else {
            $cartItems[$itemKey] = [
                'product_id' => $productId,
                'product_name' => $product->name,
                'variant_id' => $variant->id,
                'size_id' => $sizeId,
                'color_id' => $colorId,
                'item_price' => $variant->discount_price > 0 ? $variant->discount_price : $variant->unit_price,
                'quantity' => $quantity,
                'order_price' => ($variant->discount_price > 0 ? $variant->discount_price : $variant->unit_price) * $quantity
            ];
        }


        Cache::put($this->cartKey, $cartItems, now()->addDays(15));

        return response()->json(['status' => 'success', 'message' => 'Added to cart']);
    }

    public function getCartItems()
    {
        $cartKey = $this->cartKey;
        $cartItems = Cache::get($cartKey, []);
        $cartItemsArray = array_values($cartItems);

        $mergedItems = collect($cartItemsArray)->map(function ($item) {
            $product = \App\Models\Product::select('id', 'name', 'slug', 'thumbnail_path')->find($item['product_id']);
            $size = $item['size_id'] ? \App\Models\Size::select('id', 'name')->find($item['size_id']) : null;
            $color = $item['color_id'] ? \App\Models\Color::select('id', 'name')->find($item['color_id']) : null;

            return [
                ...$item,
                'product_id' => $product?->id ?? null,
                'product_name' => $product?->name ?? 'Unknown Product',
                'product_slug' => $product?->slug ?? 'Unknown Product',
                'product_thumbnail' => $product?->thumbnail_path ?? 'Unknown Product',
                'size_name' => $size?->name ?? null,
                'color_name' => $color?->name ?? null,
            ];
        });

        $itemTotal = $mergedItems->sum('order_price');

        $response['item_total'] = $itemTotal;
        $response['total_price'] = $itemTotal + shippingFee();
        $response['items'] = $mergedItems->values();
        return $response;

//        return response()->json([
//            'item_total' => $itemTotal,
//            'items' => $mergedItems->values(),
//        ]);
    }

    public function loadCartItems()
    {
        $cart_items = $this->getCartItems();
        return [
            'item_summary' => $cart_items,
            'cart_view' => view('user.pages.cart_items', compact('cart_items'))->render(),
        ];
    }


    public function updateCartQuantity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:increment,decrement',
            'product_id' => 'required|integer',
            'size_id' => 'nullable|integer',
            'color_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
        }

        $productId = $request->product_id;
        $sizeId = $request->size_id;
        $colorId = $request->color_id;
        $type = $request->type;

        $existingItem = $this->productExistsInCart($productId, $sizeId, $colorId);

        if (!$existingItem) {
            return response()->json(['status' => 'error', 'message' => 'Cart item not found']);
        }

        $newQuantity = $type === 'increment'
            ? $existingItem['quantity'] + 1
            : max(1, $existingItem['quantity'] - 1);

        return $this->updateCartItem($productId, $sizeId, $colorId, $newQuantity);
    }

    protected function updateCartItem($productId, $sizeId, $colorId, $newQuantity)
    {
        $cartItems = Cache::get($this->cartKey, []);
        $itemKey = $this->generateCartItemKey($productId, $sizeId, $colorId);

        if (isset($cartItems[$itemKey])) {
            $cartItems[$itemKey]['quantity'] = $newQuantity;
            $cartItems[$itemKey]['order_price'] = $cartItems[$itemKey]['item_price'] * $newQuantity;
            Cache::put($this->cartKey, $cartItems, now()->addDays(15));

            return response()->json(['status' => 'success', 'message' => 'Cart updated']);
        }

        return response()->json(['status' => 'error', 'message' => 'Item not found']);
    }

    public function removeFromCart(Request $request)
    {
        $productId = $request->product_id;
        $sizeId = $request->size_id;
        $colorId = $request->color_id;

        $cartItems = Cache::get($this->cartKey, []);
        $itemKey = $this->generateCartItemKey($productId, $sizeId, $colorId);

        if (isset($cartItems[$itemKey])) {
            unset($cartItems[$itemKey]);
            Cache::put($this->cartKey, $cartItems, now()->addDays(15));
            return response()->json(['status' => 'success', 'message' => 'Item removed']);
        }

        return response()->json(['status' => 'error', 'message' => 'Item not found']);
    }

    public function clearCart()
    {
        Cache::forget($this->cartKey);
        return response()->json(['status' => 'success', 'message' => 'Cart cleared']);
    }

    // Checkout and Order
    public function checkout()
    {
        if (Auth::check()) {
            $cart_items = $this->getCartItems();
            return view('user.pages.checkout',compact('cart_items'));
        }  else {
            session()->put('current_url', URL::current());
            return redirect()->route('login');
        }

    }

    public function submitOrder(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'address' => 'required|max:255',
            'country' => 'nullable',
            'city' => 'nullable',
            'zip_code' => 'required|max:10',
            'email' => 'required|email|max:50',
            'mobile' => 'required|max:20',
            'additional_information' => 'nullable|sometimes|max:500',
        ]);
        return $request;
    }
}
