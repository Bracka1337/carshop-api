<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'diameter',
        'width',
        'et',
        'cb',
        'bolt',
        'bolt_diameter',
        'type',
        'price',
        'brand_id',
    ];

    /** Public URL of the first image, or null when the product has none. */
    public function imageUrl(): ?string
    {
        $image = $this->images->first();

        return $image ? asset('storage/'.$image->img_uri) : null;
    }

    /** @return BelongsTo<Brand, $this> */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /** @return HasMany<Image, $this> */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    /** @return HasMany<OrderLine, $this> */
    public function orderLines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    /**
     * Catalogue filters shared by the shop page and the JSON API.
     * Expects input validated by ProductSearchRequest.
     *
     * @param  Builder<Product>  $query
     * @param  array<string, mixed>  $filters
     * @return Builder<Product>
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        foreach (['diameter', 'width', 'type'] as $field) {
            if (! empty($filters[$field])) {
                $query->where($field, $filters[$field]);
            }
        }

        if (! empty($filters['brand'])) {
            $query->where('brand_id', $filters['brand']);
        }

        if (! empty($filters['price_from'])) {
            $query->where('price', '>=', $filters['price_from']);
        }

        if (! empty($filters['price_to'])) {
            $query->where('price', '<=', $filters['price_to']);
        }

        $orderOptions = [
            'price_asc' => ['price', 'asc'],
            'price_desc' => ['price', 'desc'],
            'brand_asc' => ['brand_id', 'asc'],
            'brand_desc' => ['brand_id', 'desc'],
        ];

        if (! empty($filters['order']) && isset($orderOptions[$filters['order']])) {
            $query->orderBy(...$orderOptions[$filters['order']]);
        }

        return $query;
    }
}
