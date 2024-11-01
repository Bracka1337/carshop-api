<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Brand::factory()->count(61)->create(); //create brand and products
        \App\Models\Product::factory()->has(\App\Models\Image::factory()->count(3))
        ->count(200)->create();

        \App\Models\User::create([ //create admin
            'name' => 'admin',
            'email'=> 'admin@eastsquad.com',
            'password'=> Hash::make('admin'),
            'phone_nr' => 1337,
            'role' => 'Admin',
        ]);

        \App\Models\User::create([ //create default user
            'name' => 'Default user',
            'email'=> 'default@eastsquad.com',
            'password'=> Hash::make('default'),
            'phone_nr' => 12345678,
            'role' => 'User',
        ]);

        \App\Models\User::factory() // seed db with random users with orders et.c.
            ->has(\App\Models\Order::factory()->count(rand(1, 20))
                ->has(\App\Models\Product_quantity::factory()->count(3)))
        ->count(10)->create();
    }
}
