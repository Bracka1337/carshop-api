<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'date',
        'user_id',
        'payment_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function payment() { 
        return $this->hasOne(Payment::class);
    }

    public function productQuantities() {
        return $this->hasMany(Product_quantity::class);
    }
}
