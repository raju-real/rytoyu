<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Color;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Jobs\LogSellerOrderJob;
use App\Models\DeliveryCharge;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Validation\Validator as ValidationValidator;

class CacheCartController extends Controller
{
    protected string $cartKey;
    protected string $priceSummeryKey;

    public function __construct()
    {
        $this->cartKey = $this->getCartKey();
        $this->priceSummeryKey = $this->getPriceSummeryKey();
    }

    protected function getCartKey(): string
    {
        return request()->cookie('cart_key') ?? 'default_cart_key';
    }

    protected function getPriceSummeryKey(): string
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
                'seller_id' => $product->seller_id,
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
                'seller_id' => $item['seller_id'],
                'variant_id' => $item['variant_id'],
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'item_price' => $item['item_price'],
                'order_price' => $item['item_price'] * $item['quantity'],
                'product_slug' => $product->slug ?? '',
                'product_thumbnail' => $product->thumbnail_path ?? '',
                'size_name' => $size->name ?? null,
                'color_name' => $color->name ?? null,
            ];
        });

        $totalSellers = $cartItemsArray->pluck('seller_id')->unique()->count();
        $itemTotal = $cartItemsArray->sum('order_price');

        return [
            'total_seller' => $totalSellers,
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

    protected function calculatedServiceCharge($order_price)
    {

        $percentage = 2;
        return ceil($order_price * ($percentage / 100)); // Round up
        //return floor($order_price * ($percentage / 100)); // Round down
        //return intval($order_price * ($percentage / 100)); // Convert to integer (cuts decimals):
    }

    public function getShippingFee()
    {
        $cart_items = $this->getCartItems();
        $total_seller =  $cart_items['total_seller'];
        if (session()->has('selected_district')) {
            $district_slug = session('selected_district');
            $charge = DeliveryCharge::whereSlug($district_slug)->firstOrFail(['delivery_charge']);
            return $charge->delivery_charge * $total_seller;
        }
    }

    public function getPriceSummery()
    {
        $this->applyCoupon();
        $price_summery_key = $this->priceSummeryKey;
        $cart_items = $this->getCartItems();

        $total_item_price = $cart_items['item_total'];
        $shipping_fee = $this->getShippingFee();
        //        if (session()->has('selected_district')) {
        //            $district_slug = session('selected_district');
        //            $charge = DeliveryCharge::whereSlug($district_slug)->firstOrFail(['delivery_charge']);
        //            $shipping_fee = $charge->delivery_charge;
        //        }
        $item_total_discount = 0;
        $applied_coupon = null;
        $coupon_discount = 0;
        // If you have discount logic or applied coupon, you can set here:
        if (session()->has('applied_coupon_code')) {
            $applied_coupon = session('applied_coupon_code');
            $coupon_discount = session('applied_coupon_discount');
        }

        $total_discount = $item_total_discount + $coupon_discount;
        $total_amount = $total_item_price  - $coupon_discount;
        if (session()->has('selected_payment_method') && session('selected_payment_method') === 'online-payment') {
            $service_charge = $this->calculatedServiceCharge($total_amount);
        } else {
            $service_charge = 0;
        }

        $total_order_price = ($total_amount + $shipping_fee + $service_charge) - $coupon_discount;

        $price_summary = [
            'total_item_price' => $total_item_price,
            'shipping_fee' => $shipping_fee,
            'service_charge' => $service_charge,
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

    public function setShippingFee()
    {
        $validations = Validator::make(request()->all(), [
            'district' => 'required|exists:delivery_charges,slug'
        ]);
        if ($validations->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid District Selected'
            ]);
        }
        $district_slug = request()->get('district') ?? 'dhaka';
        session()->put('selected_district', $district_slug);
        return $this->getShippingFee();
    }

    public function setPaymentMethod()
    {
        $validations = Validator::make(request()->all(), [
            'payment_method' => 'required|in:cash-on-delivery,online-payment'
        ]);

        if ($validations->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid payment method selected',
                'errors' => $validations->errors()
            ]);
        }

        $payment_method = request()->get('payment_method') ?? 'dhaka';
        session()->put('selected_payment_method', $payment_method);
        $price_summery = $this->getPriceSummery();
        return response()->json([
            'status' => 'success',
            'payment_method' => $payment_method,
            'service_charge' => $price_summery['service_charge'],
            'message' => 'Payment method selected successfully'
        ]);
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
        $coupon_code = '';
        $discount = 0;
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

    protected function cartItemsCount()
    {
        $cartItems = $this->getCartItems(); // your method to fetch cart data
        if ($cartItems) {
            return count($cartItems['items']);
        } else {
            return 0;
        }
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

            return response()->json(['status' => 'success', 'message' => 'Selected item(s) removed from cart.', 'cart_item_count' => $this->cartItemsCount()]);
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

    // Wishlist manage
    public function wishlists()
    {
        $products = Wishlist::where('user_id', Auth::id())->get();
        return view('user.pages.wishlists', compact('products'));
    }

    public function addToWishList(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required'
        ]);

        $product_id = encrypt_decrypt($request->product_id, 'decrypt');
        if (Product::where('id', $product_id)->exists()) {
            if (Wishlist::where('user_id', Auth::id())->where('product_id', $product_id)->exists()) {
                return response()->json(['status' => 'error', 'message' => 'Item already added wishlist.']);
            } else {
                $wishlist = new Wishlist();
                $wishlist->user_id = Auth::id();
                $wishlist->product_id = $product_id;
                $wishlist->save();
                return response()->json(['status' => 'success', 'message' => 'Item added to wishlist.']);
            }
        }
    }

    public function deleteWishListItem($item_id)
    {
        $id = encrypt_decrypt($item_id, 'decrypt');
        if (Wishlist::where('id', $id)->exists()) {
            Wishlist::where('id', $id)->delete();
            return redirect()->route('wishlists')->with('message', 'Wishlist item removed successfully');
        }
    }

    public function checkout()
    {
        if (Auth::check()) {
            $cart_items = $this->getCartItems();
            $user = Auth::user();
            return view('user.pages.checkout', compact('cart_items', 'user'));
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
            'district' => 'required|exists:delivery_charges,slug',
            'city' => 'nullable|max:100',
            'zip_code' => 'required|max:10',
            'email' => 'required|email|max:50',
            'mobile' => 'required|max:11',
            'additional_information' => 'nullable|max:500',
        ]);
        // Carts information ...
        $cartItems = $this->getCartItems();
        $price_summery = $this->getPriceSummery();
        // Coupon
        $applied_coupon_code = $price_summery['applied_coupon'] ?? Null;
        $applied_coupon_discount = $price_summery['coupon_discount'] ?? 0;
        // Validate coupon and coupon discount here. others failed
        //        if(!empty($applied_coupon_code)) {
        //
        //        }
        // Price calculation
        $total_vat = 0;
        $total_shipping = $price_summery['shipping_fee'];
        $seller_count = $cartItems['total_seller'];
        // save order
        $order = new Order();
        $order->order_number = Order::getOrderNumber();
        $order->invoice = Order::getInvoiceNumber();
        $order->user_id = Auth::id();

        $total_item_unit_price = Order::getTotalItemUnitPrice($cartItems);
        $total_item_discount = Order::getTotalItemDiscountPrice($cartItems);
        $total_item_order_price = Order::getItemOrderPrice($cartItems);

        $order->total_item_unit_price = $total_item_unit_price;
        $order->total_item_discount = $total_item_discount;
        $order->total_item_order_price = $total_item_order_price;

        $order->coupon_code = $applied_coupon_code;
        $order->coupon_discount_amount = $applied_coupon_discount;
        $order->shipping_fee = $total_shipping;
        $order->seller_count = $seller_count;
        $order->total_vat = 0;
        $order->total_discount = $total_item_discount + $applied_coupon_discount;

        // Service charge calculation
        $order_amount = ($total_item_order_price + $total_shipping + $total_vat) - $applied_coupon_discount;

        $payment_method = session('selected_payment_method') ?? 'cash-on-delivery';
        $service_charge = 0;
        if ($payment_method === 'online-payment') {
            $service_charge = $this->calculatedServiceCharge($order_amount);
        }

        $total_order_price = ($total_item_order_price + $total_shipping + $service_charge + $total_vat) - $applied_coupon_discount;
        $order->total_order_price = $total_order_price;

        $order->payment_method = $payment_method ?? 'cash-on-delivery';
        $order->service_charge = $service_charge;
        $order->payment_status = 'unpaid';
        $order->paid_amount = 0;
        $order->due_amount = $total_order_price;

        $order->first_name = $request->first_name ?? Auth::user()->first_name ?? null;
        $order->last_name = $request->last_name ?? Auth::user()->last_name ?? null;
        $order->mobile = $request->mobile ?? Auth::user()->mobile ?? null;
        $order->email = $request->email ?? Auth::user()->email ?? null;
        $order->district_id = districtIdBySlug($request->district) ?? Auth::user()->district_id ?? null;
        $order->city_town = $request->city ?? Auth::user()->city ?? null;
        $order->address = $request->address ?? Auth::user()->delivery_address ?? Auth::user()->home_address ?? null;
        $order->post_code = $request->post_code ?? Auth::user()->zip_code ?? null;
        $order->additional_information = $request->additional_information ?? null;
        $order->order_status = 'pending';
        $order->save();

        foreach ($cartItems['items'] as $item) {
            // Carts item info
            $variant_id = $item['variant_id'];
            $product_id = $item['product_id'];
            $variant = ProductVariant::find($variant_id);
            if (!$variant) {
                continue;
            }
            $quantity = $item['quantity'];
            // Price calculation
            $item_unit_price = $variant->unit_price;
            $item_discount_price = $variant->discount_price;
            $item_order_price = $item_discount_price > 0 ? $item_discount_price : $item_unit_price;

            $item_total_unit_price = $item_unit_price * $quantity;
            $item_total_discount_price = $item_discount_price * $quantity;
            $item_total_order_price = $item_order_price * $quantity;
            // Save order items
            $order_item = new OrderProduct();
            $order_item->order_id = $order->id;
            $order_item->user_id = $order->user_id;
            $order_item->seller_id = sellerIdByProduct($product_id);
            $order_item->variant_id = $variant_id;
            $order_item->product_id = $product_id;
            $order_item->item_unit_price = $item_unit_price;
            $order_item->item_discount_price = $item_total_discount_price;
            $order_item->item_order_price = $item_order_price;
            $order_item->quantity = $quantity;
            $order_item->item_total_unit_price = $item_total_unit_price;
            $order_item->item_total_discount = $item_total_unit_price - $item_discount_price;
            $order_item->item_total_order_price = $item_total_order_price;
            $order_item->size = $variant->size_name ?? null;
            $order_item->color = $variant->color_name ?? null;
            $order_item->order_status = 'pending';
            $order_item->save();
            // Update inventory
            ProductVariant::find($variant_id)->decrement('inventory', $quantity);
        }
        // Process Order Logs and notifications
        LogSellerOrderJob::dispatch($order->id);

        $payment_method = session('selected_payment_method') ?? 'cash-on-delivery';
        $gateway = $request->input('gateway');

        $redirect_url = null;
        if ($payment_method === 'online-payment' && $gateway) {
            if ($gateway === 'sslcommerz') {
                $redirect_url = route('sslcommerz.pay-now', ['unique_id' => $order->unique_id]);
            } elseif ($gateway === 'bkash') {
                $redirect_url = route('bkash.pay-now', ['unique_id' => $order->unique_id]);
            } elseif ($gateway === 'rocket') {
                $redirect_url = route('rocket.pay-now', ['unique_id' => $order->unique_id]);
            } elseif ($gateway === 'nagad') {
                $redirect_url = route('nagad.pay-now', ['unique_id' => $order->unique_id]);
            }
        }

        // Forget old cart and price summery
        //Cache::forget($this->cartKey);
        //Cache::forget($this->priceSummeryKey);
        //session()->forget('selected_district');
        //session()->forget('selected_payment_method');
        //session()->forget('applied_coupon');
        //session()->forget('applied_coupon_discount');
        return response()->json([
            'status' => 'success',
            'message' => 'Your order has been submitted successfully.',
            'redirect_url' => $redirect_url
        ]);
    }
}
