<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Exception;

class GeminiChatBotController extends Controller
{
    /* ── Conversational keywords ──────────────────────────────── */
    private const GREETINGS    = ['hi', 'hello', 'hey', 'hola', 'greetings', 'good morning', 'good afternoon', 'good evening', 'good night', 'salam', 'salaam', 'assalamu alaikum'];
    private const THANKS_WORDS = ['thanks', 'thank you', 'thank u', 'thx', 'dhonnobad'];
    private const HELP_WORDS   = ['help', 'help me', 'support', 'assist'];
    private const OFF_TOPIC_THRESHOLD = 2; // after 2 off-topic messages, redirect gently

    public function handleQuery(Request $request)
    {
        $query     = trim($request->input('query', ''));
        $sessionId = $request->session()->getId();

        if (!$query) {
            return response()->json(['type' => 'text', 'data' => "Please type a message."]);
        }

        $lower = mb_strtolower($query);

        // ── 1. Greeting ────────────────────────────────────────────
        foreach (self::GREETINGS as $greet) {
            if (str_contains($lower, $greet)) {
                $request->session()->put("chat_offtopic_{$sessionId}", 0);
                $company = siteSettings()['company_name'] ?? 'our store';
                return response()->json([
                    'type' => 'text',
                    'data' =>
                    "👋 Hello! Welcome to **{$company}**! I'm your AI shopping assistant.\n\n" .
                        "I can help you with:\n• 🛍️ Finding products\n• 📦 Tracking your orders\n• 💬 General questions\n\n" .
                        "What are you looking for today?"
                ]);
            }
        }

        // ── 2. Thanks ──────────────────────────────────────────────
        foreach (self::THANKS_WORDS as $t) {
            if (str_contains($lower, $t)) {
                $request->session()->put("chat_offtopic_{$sessionId}", 0);
                return response()->json(['type' => 'text', 'data' => "You're most welcome! 😊 Is there anything else I can help you with? Feel free to ask about our products or your orders."]);
            }
        }

        // ── 3. Help keywords ──────────────────────────────────────
        foreach (self::HELP_WORDS as $h) {
            if ($lower === $h) {
                return response()->json([
                    'type' => 'text',
                    'data' =>
                    "Sure! Here's what I can help with:\n\n" .
                        "🛍️ **Product Search** — Just type what you're looking for, e.g. *\"show me shirts under 500\"*\n" .
                        "📦 **Order Tracking** — Type your order number like *\"track order 1001\"*\n" .
                        "💬 **General Chat** — Ask me anything!\n\n" .
                        "What would you like to do?"
                ]);
            }
        }

        // ── 4. Order Tracking ─────────────────────────────────────
        $orderPatterns = [
            '/(?:track|order|status|where is my|check)\s*(?:order|order no|no|#)?\s*[:\-]?\s*(\d{4,})/i',
            '/(?:#|no[. :]?)?\s*(\d{4,})\s*(?:track|order|status)/i',
        ];
        foreach ($orderPatterns as $pattern) {
            if (preg_match($pattern, $lower, $m)) {
                $orderNumber = $m[1];
                $order = \App\Models\Order::where('order_number', $orderNumber)
                    ->orWhere('invoice', 'like', "%{$orderNumber}%")->first();

                if ($order) {
                    $courierInfo = '';
                    if (!empty($order->courier_name) && !empty($order->courier_tracking_id)) {
                        $courierInfo = "\n🚚 Courier: **{$order->courier_name}** | Tracking ID: `{$order->courier_tracking_id}`";
                    }
                    return response()->json([
                        'type' => 'text',
                        'data' =>
                        "📦 **Order #{$order->order_number}**\n" .
                            "Status: **" . ucwords(str_replace('_', ' ', $order->order_status)) . "**\n" .
                            ($order->delivery_status ? "Delivery: **" . ucwords($order->delivery_status) . "**\n" : '') .
                            $courierInfo
                    ]);
                } else {
                    return response()->json([
                        'type' => 'text',
                        'data' =>
                        "❌ I couldn't find order **#{$orderNumber}**. Please double-check the number and try again.\n\nYou can also view your orders in your **account dashboard**."
                    ]);
                }
            }
        }

        // Generic order track prompt (no number given)
        if (preg_match('/track|order status|where is my order|my order/i', $lower)) {
            return response()->json([
                'type' => 'text',
                'data' =>
                "📦 To track your order, please share your **order number**.\n\nExample: *\"track order 1023\"*\n\nYou can find it in the confirmation email or your account dashboard."
            ]);
        }

        // ── 5. Smart Product Search ────────────────────────────────
        preg_match('/(?:under|below|max|less than)\s*([\d,]+)/i', $lower, $priceMatch);
        $priceLimit = isset($priceMatch[1]) ? (int) str_replace(',', '', $priceMatch[1]) : null;

        $searchTerm = preg_replace('/(?:under|below|max|less than)\s*[\d,]+/i', '', $lower);
        $searchTerm = preg_replace('/^(?:find|search|show|give me|show me|i want|looking for|need|buy|get|cheap|any)\s+/i', '', $searchTerm);
        $searchTerm = trim(preg_replace('/\s+/', ' ', $searchTerm));

        $isConversational = strlen($searchTerm) <= 2 ||
            in_array($searchTerm, array_merge(self::GREETINGS, self::THANKS_WORDS, self::HELP_WORDS));

        if (!$isConversational && strlen($searchTerm) > 2) {
            $productQuery = Product::where(function ($q) use ($searchTerm) {
                $keywords = array_filter(explode(' ', $searchTerm), function ($k) {
                    return strlen($k) > 1;
                });
                foreach ($keywords as $keyword) {
                    $q->orWhere('name', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%");
                }
            });

            if ($priceLimit !== null) {
                $productQuery->where(function ($q) use ($priceLimit) {
                    $q->where(function ($q2) use ($priceLimit) {
                        $q2->whereNotNull('discount_price')->where('discount_price', '<=', $priceLimit);
                    })->orWhere(function ($q2) use ($priceLimit) {
                        $q2->whereNull('discount_price')->orWhere('discount_price', 0);
                        $q2->where('unit_price', '<=', $priceLimit);
                    });
                });
            }

            $products = $productQuery->select('id', 'name', 'slug', 'unit_price', 'discount_price', 'thumbnail_path')
                ->limit(5)->get();

            if ($products->isNotEmpty()) {
                $request->session()->put("chat_offtopic_{$sessionId}", 0);
                $data = $products->map(function ($p) {
                    return [
                        'id'             => $p->id,
                        'name'           => $p->name,
                        'unit_price'     => $p->unit_price,
                        'discount_price' => $p->discount_price,
                        'slug'           => $p->slug,
                        'thumbnail_path' => $p->thumbnail_path ? url($p->thumbnail_path) : null,
                        'details_link'   => route('product-details', $p->slug),
                    ];
                });

                return response()->json([
                    'type'             => 'products',
                    'data'             => $data,
                    'total_products'   => $products->count(),
                    'original_query'   => $searchTerm,
                    'min_amount'       => $priceLimit,
                    'all_results_link' => route('product-lists', ['search' => $searchTerm, 'amount_max' => $priceLimit]),
                ]);
            }

            if (strlen($searchTerm) > 3) {
                return response()->json([
                    'type' => 'text',
                    'data' =>
                    "😔 Sorry, I couldn't find any products matching **\"{$searchTerm}\"**" .
                        ($priceLimit ? " under ৳{$priceLimit}" : "") . ".\n\n" .
                        "Try a different keyword or [browse all products](" . route('product-lists') . ")."
                ]);
            }
        }

        // ── 6. Off-topic redirect logic ───────────────────────────
        $offTopicCount = $request->session()->get("chat_offtopic_{$sessionId}", 0);

        if ($offTopicCount >= self::OFF_TOPIC_THRESHOLD) {
            $request->session()->put("chat_offtopic_{$sessionId}", 0);
            return response()->json([
                'type' => 'text',
                'data' =>
                "😊 I'm best at helping you with **products and orders**!\n\n" .
                    "• Type a product name to search (e.g. *\"show me phones\"*)\n" .
                    "• Type your order number to track (e.g. *\"track order 1001\"*)\n\n" .
                    "How can I help you shop today?"
            ]);
        }

        // ── 7. Gemini fallback (general chat) ─────────────────────
        $apiKey = env('GEMINI_API_KEY', 'AIzaSyDFG7EnRvMDVExoZr-9oDS2AX2TKaMjGZ0');

        try {
            $company      = siteSettings()['company_name'] ?? 'our store';
            $systemPrompt = "You are a friendly, helpful AI shopping assistant for {$company}, an e-commerce store. " .
                "Help customers with their questions. Keep answers SHORT (1-3 sentences). " .
                "If they ask about unrelated topics, politely guide them toward browsing products or tracking orders. " .
                "Always maintain a warm, professional tone.";

            $response = Http::timeout(15)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}",
                ['contents' => [['parts' => [['text' => "{$systemPrompt}\n\nUser: {$query}"]]]]]
            );

            if ($response->successful()) {
                $text = $response->json('candidates.0.content.parts.0.text');
                if ($text) {
                    $request->session()->put("chat_offtopic_{$sessionId}", $offTopicCount + 1);
                    return response()->json(['type' => 'text', 'data' => $text]);
                }
            }

            return response()->json(['type' => 'text', 'data' => "I couldn't get a response right now. Please try searching for a product or ask about your order!"]);
        } catch (Exception $e) {
            return response()->json(['type' => 'text', 'data' => "Network error. Please check your internet connection."], 500);
        }
    }
}
