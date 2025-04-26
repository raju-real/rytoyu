<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class TableCartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->product_id;
        $sizeId = $request->size_id;
        $colorId = $request->color_id;
        $quantity = $request->quantity ?? 1;

        $browserId = $request->cookie('browser_id') ?? (string) \Str::uuid();
        $userId = auth()->id();

        $product = Product::findOrFail($productId);

        // Determine variant
        $variantQuery = ProductVariant::where('product_id', $productId);
        if ($sizeId && $colorId) {
            $variantQuery->where('size_id', $sizeId)->where('color_id', $colorId);
        } elseif ($sizeId) {
            $variantQuery->where('size_id', $sizeId);
        } elseif ($colorId) {
            $variantQuery->where('color_id', $colorId);
        }

        $variant = $variantQuery->first();

        if (!$variant) {
            // fallback to default
            $variant = ProductVariant::where('product_id', $productId)->first();
            if (!$variant) {
                return response()->json(['message' => 'Product variant not found.'], 422);
            }
        }

        $itemPrice = $variant->discount_price > 0 ? $variant->discount_price : $variant->unit_price;
        $orderPrice = $itemPrice * $quantity;

        $cartItem = Cart::where('product_id', $productId)
            ->where('variant_id', $variant->id)
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(!$userId, fn($q) => $q->where('browser_id', $browserId))
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->order_price = $cartItem->item_price * $cartItem->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'browser_id' => $userId ? null : $browserId,
                'user_id' => $userId,
                'product_id' => $productId,
                'variant_id' => $variant->id,
                'size_id' => $variant->size_id,
                'color_id' => $variant->color_id,
                'quantity' => $quantity,
                'item_price' => $itemPrice,
                'order_price' => $orderPrice,
            ]);
        }

        return response()->json(['message' => 'Product added to cart.'])
                         ->cookie('browser_id', $browserId, 60 * 24 * 15); // 15 days
    }

    public function getCartItems(Request $request)
    {
        $browserId = $request->cookie('browser_id');
        $userId = auth()->id();

        $cartItems = Cart::with(['product:id,name', 'variant', 'size:id,name', 'color:id,name'])
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(!$userId, fn($q) => $q->where('browser_id', $browserId))
            ->get();

        $itemTotal = $cartItems->sum('order_price');

        return response()->json([
            'item_total' => $itemTotal,
            'items' => $cartItems,
        ]);
    }

    public function updateQuantity(Request $request)
    {
        $productId = $request->product_id;
        $variantId = $request->variant_id;
        $quantity = $request->quantity;
        $browserId = $request->cookie('browser_id');
        $userId = auth()->id();

        $cartItem = Cart::where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(!$userId, fn($q) => $q->where('browser_id', $browserId))
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found.'], 404);
        }

        $cartItem->quantity = $quantity;
        $cartItem->order_price = $cartItem->item_price * $quantity;
        $cartItem->save();

        return response()->json(['message' => 'Cart updated successfully.']);
    }

    public function removeItem(Request $request)
    {
        $productId = $request->product_id;
        $variantId = $request->variant_id;
        $browserId = $request->cookie('browser_id');
        $userId = auth()->id();

        $deleted = Cart::where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(!$userId, fn($q) => $q->where('browser_id', $browserId))
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Item removed from cart.']);
        }

        return response()->json(['message' => 'Item not found.'], 404);
    }

    public function clearCart(Request $request)
    {
        $browserId = $request->cookie('browser_id');
        $userId = auth()->id();

        Cart::when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(!$userId, fn($q) => $q->where('browser_id', $browserId))
            ->delete();

        return response()->json(['message' => 'Cart cleared.']);
    }
}
