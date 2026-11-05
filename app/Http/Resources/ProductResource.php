<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Product */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'brand' => $this->whenLoaded('brand', fn () => [
                'id' => $this->brand->id,
                'title' => $this->brand->title,
            ]),
            'type' => $this->type,
            'price' => (float) $this->price,
            'specs' => [
                'diameter' => (int) $this->diameter,
                'width' => (float) $this->width,
                'et' => (float) $this->et,
                'cb' => (float) $this->cb,
                'bolt' => (int) $this->bolt,
                'bolt_diameter' => (float) $this->bolt_diameter,
            ],
            'images' => $this->whenLoaded('images', fn () => $this->images
                // Images live on the "public" disk, served via `php artisan storage:link`.
                ->map(fn ($image) => asset('storage/'.$image->img_uri))
                ->values()),
        ];
    }
}
