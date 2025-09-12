<?php

namespace App\Services;

use App\Models\Product;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class ProductChatbotConversation extends Conversation
{
    protected $productName;
    protected $price;

    public function run()
    {
        $this->askAboutProducts();
    }

    public function askAboutProducts()
    {
        $question = Question::create('Hi! How can I help you find products today?')
            ->fallback('Unable to ask question')
            ->callbackId('ask_about_products')
            ->addButtons([
                Button::create('Search by name')->value('name'),
                Button::create('Search by price')->value('price'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue();

                if ($selectedValue === 'name') {
                    $this->askForProductName();
                } elseif ($selectedValue === 'price') {
                    $this->askForPriceRange();
                }
            } else {
                // Handle natural language input
                $text = strtolower($answer->getText());

                // Check if it contains price information
                if (preg_match('/(under|below|less than|up to)\s*\$?(\d+)/', $text, $matches)) {
                    $maxPrice = $matches[2];
                    $this->searchProductsByPrice(0, $maxPrice);
                }
                elseif (preg_match('/(over|above|more than|greater than)\s*\$?(\d+)/', $text, $matches)) {
                    $minPrice = $matches[2];
                    $this->searchProductsByPrice($minPrice, 10000);
                }
                elseif (preg_match('/\$?(\d+)\s*-\s*\$?(\d+)/', $text, $matches)) {
                    $minPrice = $matches[1];
                    $maxPrice = $matches[2];
                    $this->searchProductsByPrice($minPrice, $maxPrice);
                }
                elseif (preg_match('/(show|find|search).*(product|item).*(named|called|for)\s+(.+)/', $text, $matches)) {
                    $this->productName = $matches[4];
                    $this->searchProductsByName();
                }
                else {
                    // Assume it's a product name
                    $this->productName = $text;
                    $this->searchProductsByName();
                }
            }
        });
    }

    public function askForProductName()
    {
        $this->ask('What product are you looking for?', function (Answer $answer) {
            $this->productName = $answer->getText();
            $this->searchProductsByName();
        });
    }

    public function askForPriceRange()
    {
        $this->ask('What is your price range? (e.g., 10-50 or under 30)', function (Answer $answer) {
            $priceRange = $answer->getText();

            if (preg_match('/(under|below|less than|up to)\s*\$?(\d+)/', $priceRange, $matches)) {
                $maxPrice = $matches[2];
                $this->searchProductsByPrice(0, $maxPrice);
            }
            elseif (preg_match('/(over|above|more than|greater than)\s*\$?(\d+)/', $priceRange, $matches)) {
                $minPrice = $matches[2];
                $this->searchProductsByPrice($minPrice, 10000);
            }
            elseif (preg_match('/\$?(\d+)\s*-\s*\$?(\d+)/', $priceRange, $matches)) {
                $minPrice = $matches[1];
                $maxPrice = $matches[2];
                $this->searchProductsByPrice($minPrice, $maxPrice);
            }
            else {
                $this->say('Please provide a valid price range like "10-50" or "under 30"');
                $this->askForPriceRange();
            }
        });
    }

    public function searchProductsByName()
    {
//        $products = Product::where('name', 'LIKE', '%'.$this->productName.'%')
//            ->orWhere('slug', 'LIKE', '%'.$this->productName.'%')
//            ->orWhere('short_description', 'LIKE', '%'.$this->productName.'%')
//            ->take(5) // Limit to 5 products
//            ->get();
        $data = Product::query();
        $data->whereRaw("MATCH(name) AGAINST (? IN BOOLEAN MODE)", [$this->productName]);
        $products = $data->take(10)->get();

        if ($products->count() > 0) {
            $this->say("I found {$products->count()} product(s) matching '{$this->productName}':");
            $this->displayProducts($products);
        } else {
            $this->say("Sorry, no products found with '{$this->productName}'.");
            $this->suggestSimilarProducts();
        }

        $this->askAboutProducts();
    }

    public function searchProductsByPrice($minPrice, $maxPrice)
    {
        $products = Product::whereBetween('unit_price', [$minPrice, $maxPrice])
            ->take(5) // Limit to 5 products
            ->get();

        if ($products->count() > 0) {
            $this->say("I found {$products->count()} product(s) between \${$minPrice} and \${$maxPrice}:");
            $this->displayProducts($products);
        } else {
            $this->say("Sorry, no products found between \${$minPrice} and \${$maxPrice}.");
        }

        $this->askAboutProducts();
    }

    public function suggestSimilarProducts()
    {
        // Try to find similar products by breaking down the search term
        $words = explode(' ', $this->productName);
        if (count($words) > 1) {
            $firstWord = $words[0];
            $similarProducts = Product::where('name', 'LIKE', '%'.$firstWord.'%')
                ->take(3)
                ->get();

            if ($similarProducts->count() > 0) {
                $this->say("Maybe you're interested in these similar products:");
                $this->displayProducts($similarProducts);
            }
        }
    }

    public function displayProducts($products)
    {
        foreach ($products as $product) {
            $imageUrl = $product->thumbnail_path ? asset($product->thumbnail_path) : asset('assets/user/img/no-image.png');

            $message = "PRODUCT_CARD:" . json_encode([
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->unit_price,
                'description' => $product->short_description,
                'image' => $imageUrl,
                'link' => route('product-details', $product->slug)
            ]);

            $this->say($message);
        }
    }
}
