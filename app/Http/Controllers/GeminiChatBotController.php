<?php

namespace App\Http\Controllers;

use App\Models\Product;

// Assuming your product model is here
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

// For making HTTP requests to Gemini
use Exception;
use GuzzleHttp\Exception\ClientException;

class GeminiChatBotController extends Controller
{
    public function handleQuery(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([
                'type' => 'text',
                'data' => "Please enter a message to chat."
            ]);
        }

        // --- Step 1: Smart Product Search with Price Filtering ---
        // Use a regular expression to extract the product name and price from the query
        $productName = preg_replace('/under\s+\d+/', '', $query);
        $productName = trim(strtolower($productName));

        preg_match('/under\s+(\d+)/', strtolower($query), $matches);
        $priceLimit = isset($matches[1]) ? (int)$matches[1] : null;

        // Start the query with the product name search
        $products = Product::where(function ($q) use ($productName) {
            $keywords = explode(' ', $productName);
            foreach ($keywords as $keyword) {
                if (!empty($keyword)) {
                    $q->orWhere('name', 'like', '%' . $keyword . '%');
                }
            }
        });

        // Apply the conditional price filtering if a price limit was found
        if ($priceLimit !== null) {
            $products->where(function ($q) use ($priceLimit) {
                // Case 1: Filter by discount_price if it exists and is within the limit
                $q->whereNotNull('discount_price')
                    ->where('discount_price', '<=', $priceLimit);
            })->orWhere(function ($q) use ($priceLimit) {
                // Case 2: If no discount_price, filter by unit_price if it's within the limit
                $q->whereNull('discount_price')
                    ->where('unit_price', '<=', $priceLimit);
            });
        }

        $filteredProducts = $products->select('id', 'name', 'slug', 'unit_price', 'discount_price', 'thumbnail_path')->get();

        if ($filteredProducts->isNotEmpty()) {
            // Map the products to send only necessary data, including the full thumbnail path
            $data = $filteredProducts->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'unit_price' => $product->unit_price,
                    'discount_price' => $product->discount_price,
                    'slug' => $product->slug,
                    'thumbnail_path' => url($product->thumbnail_path),
                    'details_link' => route('product-details', $product->slug)
                ];
            });

            return response()->json([
                'type' => 'products',
                'data' => $data,
                'total_products' => $filteredProducts->count(),
                'original_query' => $productName,
                'min_amount' => $priceLimit,
                'all_results_link' => route('product-lists', ['search' => $productName,'amount_min' => $priceLimit])
            ]);
        } else {
            // --- Step 2: General Chat with Gemini API ---
            $apiKey = "AIzaSyDFG7EnRvMDVExoZr-9oDS2AX2TKaMjGZ0";

            if (!$apiKey) {
                return response()->json([
                    'type' => 'text',
                    'data' => "API Key Error: The Google Gemini API key is missing. Please set it in your .env file."
                ], 500);
            }

            try {
                $payload = [
                    'contents' => [['parts' => [['text' => $query]]]],
                    'tools' => [['google_search' => (object)[]]],
                ];

                $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-05-20:generateContent?key={$apiKey}", $payload);

                if ($response->successful()) {
                    $geminiResponse = $response->json();

                    if (isset($geminiResponse['candidates'][0]['content']['parts'][0]['text'])) {
                        $generatedText = $geminiResponse['candidates'][0]['content']['parts'][0]['text'];
                        return response()->json([
                            'type' => 'text',
                            'data' => $generatedText
                        ]);
                    } else {
                        return response()->json([
                            'type' => 'text',
                            'data' => "Sorry, I couldn't generate a response. The API returned an empty or invalid response."
                        ], 500);
                    }
                } else {
                    $errorDetails = $response->json();
                    return response()->json([
                        'type' => 'text',
                        'data' => "API Error: The request failed with status " . $response->status() . ". " . ($errorDetails['error']['message'] ?? 'Unknown error.')
                    ], 500);
                }
            } catch (ClientException $e) {
                return response()->json([
                    'type' => 'text',
                    'data' => "HTTP Client Error: The request failed. " . $e->getMessage()
                ], 500);
            } catch (Exception $e) {
                return response()->json([
                    'type' => 'text',
                    'data' => "Network Error: Could not connect to the Gemini API. Please check your internet connection."
                ], 500);
            }
        }
    }
}
