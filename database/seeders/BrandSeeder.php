<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    public function run()
    {
        DB::table('brands')->insert([
            [
                'title' => 'Brand A',
                'description' => 'Description for Brand A',
                'country' => 'USA'
            ],
            [
                'title' => 'Brand B',
                'description' => 'Description for Brand B',
                'country' => 'Germany'
            ]
        ]);
    }
}

