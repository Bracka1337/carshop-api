<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_quantity extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'order_id',
        'product_id',
    ];

    // public function products()
    // {
    //     return $this->belongsTo(Product::class);
    // }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function orders()
    {
        return $this->belongsTo(Order::class);
    }
}
