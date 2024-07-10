<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'title' => 'RIM Model A',
                'description' => 'Description for RIM Model A',
                'img_uri' => 'http://example.com/rim_model_a.jpg',
                'material' => 'Aluminum',
                'size' => '17 inch',
                'price' => 99.99,
                'brand_id' => 1,
                'category_id' => 1
            ],
            [
                'title' => 'RIM Model B',
                'description' => 'Description for RIM Model B',
                'img_uri' => 'http://example.com/rim_model_b.jpg',
                'material' => 'Steel',
                'size' => '18 inch',
                'price' => 119.99,
                'brand_id' => 2,
                'category_id' => 1
            ],
            [
                'title' => 'RIM Model C',
                'description' => 'Description for RIM Model C',
                'img_uri' => 'http://example.com/rim_model_c.jpg',
                'material' => 'Carbon Fiber',
                'size' => '19 inch',
                'price' => 149.99,
                'brand_id' => 3,
                'category_id' => 1
            ],
            [
                'title' => 'RIM Model D',
                'description' => 'Description for RIM Model D',
                'img_uri' => 'http://example.com/rim_model_d.jpg',
                'material' => 'Magnesium',
                'size' => '20 inch',
                'price' => 179.99,
                'brand_id' => 4,
                'category_id' => 1
            ],
            [
                'title' => 'RIM Model E',
                'description' => 'Description for RIM Model E',
                'img_uri' => 'http://example.com/rim_model_e.jpg',
                'material' => 'Aluminum',
                'size' => '21 inch',
                'price' => 199.99,
                'brand_id' => 1,
                'category_id' => 1
            ],
            [
                'title' => 'RIM Model F',
                'description' => 'Description for RIM Model F',
                'img_uri' => 'http://example.com/rim_model_f.jpg',
                'material' => 'Steel',
                'size' => '22 inch',
                'price' => 219.99,
                'brand_id' => 2,
                'category_id' => 1
            ]
        ]);
    }
}
