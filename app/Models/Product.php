<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product_quantity;

class Product extends Model
{
    use HasFactory;

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

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function images() {
        return $this->hasMany(Image::class);
    }

    public function productQuantities() {
        return $this->hasMany(Product_quantity::class);
    }

}
