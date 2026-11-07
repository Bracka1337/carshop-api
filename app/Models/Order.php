<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'status',
        'date',
        'user_id',
        'delivery_details_id',
        'payment_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'id', 'payment_id');
    }

    public function delivery_details()
    {
        return $this->belongsTo(Delivery_details::class);
    }

    public function productQuantities()
    {
        return $this->hasMany(Product_quantity::class);
    }

    /**
     * Order totals: 21% VAT (included in prices, shown for information) and
     * a 2% shipping fee for orders up to 1000. "total" includes shipping.
     *
     * @return array{subtotal: float, tax: float, shipping: float, total: float}
     */
    public function costBreakdown(): array
    {
        $subtotal = $this->productQuantities->sum(
            fn ($item) => floatval($item->quantity) * floatval($item->product->price)
        );

        $shipping = $subtotal <= 1000 ? $subtotal * 0.02 : 0;

        return [
            'subtotal' => round($subtotal, 2),
            'tax' => round($subtotal * 0.21, 2),
            'shipping' => round($shipping, 2),
            'total' => round($subtotal + $shipping, 2),
        ];
    }

    public function getPaymentStatusAttributes()
    {
        $status = $this->payment->status;
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

    public function getDeliveryStatusAttributes()
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
