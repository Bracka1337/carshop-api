<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Services\TotalsCalculator;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property OrderStatus $status
 */
class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'status',
        'date',
        'user_id',
        'delivery_details_id',
        'payment_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return HasOne<Payment, $this> */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'id', 'payment_id');
    }

    /** @return BelongsTo<Delivery_details, $this> */
    public function delivery_details(): BelongsTo
    {
        return $this->belongsTo(Delivery_details::class);
    }

    /** @return HasMany<Product_quantity, $this> */
    public function productQuantities(): HasMany
    {
        return $this->hasMany(Product_quantity::class);
    }

    /**
     * Order totals from the stored line prices, calculated the same way as
     * at checkout (TotalsCalculator): subtotal without VAT, the VAT included
     * in the prices, shipping, and the total paid.
     *
     * @return array{subtotal: float, tax: float, shipping: float, total: float}
     */
    public function costBreakdown(): array
    {
        $itemsTotal = $this->productQuantities->sum(
            fn (Product_quantity $item) => $item->lineTotal()
        );

        return app(TotalsCalculator::class)->forItems($itemsTotal);
    }

    /**
     * Badge classes and label for the payment status on shop pages.
     *
     * @return array{string, string, string}
     */
    public function getPaymentStatusAttributes(): array
    {
        $status = $this->payment?->status;

        return $status
            ? [...$status->badgeClasses(), $status->value]
            : ['bg-gray-200', 'text-gray-600', 'Unknown'];
    }

    /**
     * Badge classes and label for the delivery status on shop pages.
     *
     * @return array{string, string, string}
     */
    public function getDeliveryStatusAttributes(): array
    {
        return [...$this->status->badgeClasses(), $this->status->value];
    }
}
