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
                'title' => 'BBS',
                'description' => 'High-quality wheels for performance and luxury cars',
                'country' => 'Germany'
            ],
            [
                'title' => 'Enkei',
                'description' => 'Innovative and reliable wheels for motorsports and street cars',
                'country' => 'Japan'
            ],
            [
                'title' => 'OZ Racing',
                'description' => 'Italian wheels known for their design and performance',
                'country' => 'Italy'
            ],
            [
                'title' => 'HRE Performance Wheels',
                'description' => 'Premium forged wheels designed for supercars and luxury vehicles',
                'country' => 'USA'
            ],
            [
                'title' => 'Rotiform',
                'description' => 'Unique and custom wheels for various types of vehicles',
                'country' => 'USA'
            ],
            [
                'title' => 'Rays Engineering',
                'description' => 'Leading manufacturer of high-performance wheels for motorsports',
                'country' => 'Japan'
            ],
            [
                'title' => 'American Racing',
                'description' => 'Classic and modern wheels for muscle cars and trucks',
                'country' => 'USA'
            ],
            [
                'title' => 'Konig Wheels',
                'description' => 'Affordable and stylish wheels for a wide range of vehicles',
                'country' => 'USA'
            ],
            [
                'title' => 'SSR Wheels',
                'description' => 'High-performance wheels for racing and street applications',
                'country' => 'Japan'
            ],
            [
                'title' => 'Volk Racing',
                'description' => 'Lightweight and strong wheels for racing and high-performance vehicles',
                'country' => 'Japan'
            ]
        ]);
    }
}

