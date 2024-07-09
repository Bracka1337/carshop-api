<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $primaryKey = 'brand_id';

    protected $fillable = [
        'title',
        'description',
        'country',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'manufacturer_id');
    }
}
