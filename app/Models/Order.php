<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'status',
        'quantity',
        'date',
        'user_id',
        'payment_id',
    ];

    public function productQuantities()
    {
        return $this->hasMany(Product_quantity::class, 'order_id', 'id');
    }
}
