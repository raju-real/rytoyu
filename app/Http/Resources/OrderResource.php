<?php

namespace App\Http\Resources; // Adjust your namespace

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth; // Make sure to import Auth if used

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return object
     */
    public function toArray($request): object
    {
        // Cast to (object) to ensure object-like access in Blade
        return (object) [
            'id' => $this->id,
            'invoice' => $this->invoice,
            'order_number' => $this->order_number,
            'created_at' => $this->created_at,
            'total_order_price' => authAdminType() === 'seller'
                ? $this->seller_order_logs
                        ->where('order_id', $this->id)
                        ->where('seller_id', Auth::id())
                        ->first()?->order_amount ?? 0
                : $this->total_order_price,
            // Add other fields you need in your view here
        ];
    }
}
