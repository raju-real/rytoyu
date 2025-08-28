<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use OpenAI\Laravel\Facades\OpenAI;

class ChatbotController extends Controller
{
    public function handleChat(Request $request)
    {

        $message = $request->message;

        // Call Python microservice
        $response = Http::post('http://127.0.0.1:5005/parse', ['message' => $message]);
        $data = $response->json();

        // If greeting, return directly
        if (isset($data['intent']) && $data['intent'] == 'greeting') {
            return response()->json(['reply' => $data['reply']]);
        }

        // Extract search info
        $keywords = $data['keywords'] ?? null;
        $min_price = $data['min_price'] ?? null;
        $max_price = $data['max_price'] ?? null;

        // Query products
        $query = \App\Models\Product::query();
        if ($keywords) $query->where('name', 'like', "%{$keywords}%");
        if ($min_price && $max_price) {
            $query->where(function ($q) use ($min_price, $max_price) {
                $q->whereBetween('unit_price', [$min_price, $max_price])
                    ->orWhereBetween('discount_price', [$min_price, $max_price]);
            });
        }

        $products = $query->take(5)->get(['name', 'unit_price', 'discount_price']);

        // Build response
        if ($products->isEmpty()) {
            $reply = "Sorry, no products found for your search.";
        } else {
            $reply = "I found these products:\n";
            foreach ($products as $p) {
                $price = $p->discount_price > 0 ? $p->discount_price : $p->unit_price;
                $reply .= "- {$p->name} (৳{$price})\n";
            }
        }

        // Add tip from AI if available
        if (isset($data['tip'])) {
            $reply .= "\n💡 Tip: " . $data['tip'];
        }

        return response()->json(['reply' => $reply]);
    }
}
