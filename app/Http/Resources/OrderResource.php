<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Order */
class OrderResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'date' => $this->date,
            'payment_status' => $this->payment?->status,
            'delivery' => $this->whenLoaded('deliveryDetails', fn () => [
                'method' => $this->deliveryDetails?->delivery_method,
                'payment_method' => $this->deliveryDetails?->payment_method,
                'country' => $this->deliveryDetails?->country,
            ]),
            'items' => $this->lines->map(fn ($item) => [
                'product_id' => $item->product_id,
                'title' => $item->product?->title,
                'unit_price' => (float) $item->unit_price,
                'quantity' => (int) $item->quantity,
                'line_total' => $item->lineTotal(),
            ])->values(),
            'totals' => $this->costBreakdown(),
        ];
    }
}
