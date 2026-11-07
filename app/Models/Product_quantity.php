<?php

namespace App\Models;

use Database\Factories\Product_quantityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * One order line: a product, how many, and the unit price at the time of the order.
 */
class Product_quantity extends Model
{
    /** @use HasFactory<Product_quantityFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quantity',
        'unit_price',
        'order_id',
        'product_id',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        // Lines created without an explicit price (admin panel, seeder)
        // take the product's current price.
        static::creating(function (Product_quantity $line) {
            if (($line->getAttributes()['unit_price'] ?? null) === null) {
                $line->unit_price = Product::withTrashed()->findOrFail($line->product_id)->price;
            }
        });
    }

    public function lineTotal(): float
    {
        return round((float) $this->unit_price * $this->quantity, 2);
    }

    /** @return BelongsTo<Product, $this> */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /** @return BelongsTo<Order, $this> */
    public function orders(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
