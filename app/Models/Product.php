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

}
