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
        \App\Models\Brand::factory()->count(5)->create();
        \App\Models\Category::factory()->count(5)->create();
        \App\Models\Product::factory()->count(200)->create();
        \App\Models\User::factory()
            ->has(\App\Models\Order::factory()
                ->has(\App\Models\Product_quantity::factory()->count(3))
            ->count(rand(1, 20)))
        ->count(10)->create();
    }
}
