<?php

namespace App\Models;

use Database\Factories\DeliveryDetailFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryDetail extends Model
{
    /** @use HasFactory<DeliveryDetailFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'f_name',
        'm_name',
        'l_name',
        'addr_line_1',
        'addr_line_2',
        'country',
        'company_email',
        'company_name',
        'company_reg_nr',
        'payment_method',
        'delivery_method',
    ];

    /** @return HasOne<Order, $this> */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'delivery_details_id');
    }
}
