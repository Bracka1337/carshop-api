<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\Image;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\User;
use Database\Factories\BrandFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Brand::factory()->count(count(BrandFactory::NAMES))->create();
        Product::factory()->has(Image::factory()->count(3))
            ->count(200)->create();

        User::create([ // create admin
            'name' => 'admin',
            'email' => 'admin@eastsquad.com',
            'password' => Hash::make('admin'),
            'phone_nr' => 1337,
            'role' => 'Admin',
        ]);

        User::create([ // create default user
            'name' => 'Default user',
            'email' => 'default@eastsquad.com',
            'password' => Hash::make('default'),
            'phone_nr' => 12345678,
            'role' => 'User',
        ]);

        User::factory() // seed db with random users with orders et.c.
            ->has(Order::factory()->count(rand(1, 20))
                ->has(OrderLine::factory()->count(3), 'lines'))
            ->count(10)->create();
    }
}
