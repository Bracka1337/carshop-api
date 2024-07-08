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
                'title' => 'Product 1',
                'description' => 'Description for Product 1',
                'img_uri' => 'http://example.com/product1.jpg',
                'material' => 'Plastic',
                'size' => 'Small',
                'price' => 9.99,
                'brand_id' => 1,
                'category_id' => 1
            ],

        ]);
    }
}
