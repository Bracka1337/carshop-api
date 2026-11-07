<?php

namespace App\Models;

use App\Services\ShippingCalculator;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

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
     * Order totals: 21% VAT (included in prices, shown for information) and
     * shipping from ShippingCalculator, the same rule checkout uses.
     * "total" includes shipping.
     *
     * @return array{subtotal: float, tax: float, shipping: float, total: float}
     */
    public function costBreakdown(): array
    {
        $subtotal = $this->productQuantities->sum(
            fn (Product_quantity $item) => $item->lineTotal()
        );

        $shipping = app(ShippingCalculator::class)->cost($subtotal);

        return [
            'subtotal' => round($subtotal, 2),
            'tax' => round($subtotal * 0.21, 2),
            'shipping' => round($shipping, 2),
            'total' => round($subtotal + $shipping, 2),
        ];
    }

    /** @return array{string, string, string} */
    public function getPaymentStatusAttributes(): array
    {
        $status = $this->payment?->status;
        switch ($status) {
            case 'Refunded':
                return ['bg-red-200', 'text-red-600', 'Refunded'];
            case 'Success':
                return ['bg-green-200', 'text-green-600', 'Success'];
            case 'Failed':
                return ['bg-red-200', 'text-gray-600', 'Failed'];
            case 'Processing':
                return ['bg-yellow-200', 'text-yellow-600', 'Processing'];
            default:
                return ['bg-gray-200', 'text-gray-600', 'Unknown'];
        }
    }

    /** @return array{string, string, string} */
    public function getDeliveryStatusAttributes(): array
    {
        $status = $this->status;
        switch ($status) {
            case 'Delivering':
                return ['bg-blue-200', 'text-blue-600', 'Delivering'];
            case 'Delivered':
                return ['bg-green-200', 'text-green-600', 'Delivered'];
            case 'Failed':
                return ['bg-red-200', 'text-red-600', 'Failed'];
            case 'Processing':
                return ['bg-yellow-200', 'text-yellow-600', 'Processing'];
            default:
                return ['bg-gray-200', 'text-gray-600', 'Unknown'];
        }
    }
}
