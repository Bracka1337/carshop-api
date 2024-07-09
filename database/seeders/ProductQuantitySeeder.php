<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductQuantitySeeder extends Seeder
{
    public function run()
    {
        DB::table('product_quantities')->insert([
            [
                'quantity' => 100,
                'order_id' => 1,
                'product_id' => 1
            ],
            [
                'quantity' => 50,
                'order_id' => 2,
                'product_id' => 2
            ]
        ]);
    }
}