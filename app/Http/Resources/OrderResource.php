<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Order */
class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'date' => $this->date,
            'payment_status' => $this->payment?->status,
            'delivery' => $this->whenLoaded('delivery_details', fn () => [
                'method' => $this->delivery_details?->delivery_method,
                'payment_method' => $this->delivery_details?->payment_method,
                'country' => $this->delivery_details?->country,
            ]),
            'items' => $this->productQuantities->map(fn ($item) => [
                'product_id' => $item->product_id,
                'title' => $item->product?->title,
                'unit_price' => (float) $item->product?->price,
                'quantity' => (int) $item->quantity,
                'line_total' => round((float) $item->product?->price * (int) $item->quantity, 2),
            ])->values(),
            'totals' => $this->costBreakdown(),
        ];
    }
}
