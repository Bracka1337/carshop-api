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
        'delivery_details',
        'payment_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'id', 'payment_id');
    }

    public function productQuantities()
    {
        return $this->hasMany(Product_quantity::class);
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
