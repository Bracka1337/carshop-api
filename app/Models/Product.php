<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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

    /**
     * The title without its leading brand name, so pages that show the brand
     * separately don't repeat it: "OZ Racing Apex 18x8" → "Apex 18x8".
     */
    public function modelName(): string
    {
        return self::withoutBrand($this->title, $this->brand?->title);
    }

    /** Also used for cart items, which keep the title and brand as strings. */
    public static function withoutBrand(string $title, ?string $brand): string
    {
        $brand = (string) $brand;

        if ($brand !== '' && Str::startsWith(Str::lower($title), Str::lower($brand).' ')) {
            return trim(Str::substr($title, Str::length($brand)));
        }

        return $title;
    }

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

        $brandTitle = Brand::select('title')->whereColumn('brands.id', 'products.brand_id');

        match ($filters['order'] ?? null) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'brand_asc' => $query->orderBy($brandTitle),
            'brand_desc' => $query->orderByDesc($brandTitle),
            default => null,
        };

        return $query;
    }
}
