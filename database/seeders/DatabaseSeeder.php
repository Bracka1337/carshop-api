<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Brand::factory()->count(61)->create();
        \App\Models\Product::factory()->has(\App\Models\Image::factory()->count(2))
        ->count(200)->create();
        \App\Models\User::factory()
            ->has(\App\Models\Order::factory()
                ->has(\App\Models\Product_quantity::factory()->count(3))
            ->count(rand(1, 20)))
        ->count(10)->create();
    }
}
