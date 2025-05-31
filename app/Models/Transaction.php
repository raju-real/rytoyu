<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function generateTransactionId($order_number)
    {
        // Ensure the order number is always 4 digits
        $order_number = str_pad($order_number, 4, '0', STR_PAD_LEFT);
        // Map digits to letters (pseudo-random or fixed mapping)
        $map = ['0' => 'A', '1' => 'B', '2' => 'C', '3' => 'D', '4' => 'E', '5' => 'F', '6' => 'G', '7' => 'H', '8' => 'I', '9' => 'J'];
        $encoded = '';
        $randomLetters = ['Y', 'Z', 'X', 'W', 'T']; // Fixed extra random chars (can be randomized further)
        // Mix letter-number pattern
        foreach (str_split($order_number) as $i => $digit) {
            $letter = $map[$digit];
            $encoded .= $letter . $digit;
        }
        // Add a suffix letter to differentiate
        $encoded .= $randomLetters[rand(0, count($randomLetters) - 1)];
        $generated = strtoupper($encoded);
        $random = Str::upper(Str::random(10));
        $transaction_id = $generated.$random;
        if(Transaction::where('transaction_id',$transaction_id)->exists()) {
            Transaction::generateTransactionId($order_number);
        }
        return $transaction_id;
    }
}
