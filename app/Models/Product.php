<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'preview_img_uri',
        'material',
        'size',
        'price',
        'brand_id',
        'category_id',
    ];
}
