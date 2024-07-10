<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['title' => 'Alloy Wheels'],
            ['title' => 'Steel Wheels'],
            ['title' => 'Performance Rims'],
            ['title' => 'Off-Road Rims'],
            ['title' => 'Custom Rims'],
            ['title' => 'Spare Wheels'],
        ]);
    }
}
