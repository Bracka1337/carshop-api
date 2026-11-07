<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
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

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function productQuantities()
    {
        return $this->hasMany(Product_quantity::class);
    }

    /**
     * Catalogue filters shared by the shop page and the JSON API.
     * Expects input validated by ProductSearchRequest.
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
