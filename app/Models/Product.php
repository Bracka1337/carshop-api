<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description',
        'img_uri',
        'material',
        'size',
        'price',
        'brand_id',
        'category_id',
    ];

    public function productQuantities()
    {
        return $this->hasMany(Product_quantity::class, 'product_id');
    }
}
