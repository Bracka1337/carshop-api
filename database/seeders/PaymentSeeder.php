<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        DB::table('payments')->insert([
            [
                'status' => 'Paid',
                'date' => now()
            ],
            [
                'status' => 'Pending',
                'date' => now()
            ]
        ]);
    }
}
