<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run()
    {
        DB::table('orders')->insert([
            [
                'status' => 'Pending',
                'quantity' => 100,
                'date' => now(),
                'user_id' => 1,
                'payment_id' => 1
            ],
            [
                'status' => 'Completed',
                'quantity' => 50,
                'date' => now(),
                'user_id' => 2,
                'payment_id' => 2
            ]
        ]);
    }
}