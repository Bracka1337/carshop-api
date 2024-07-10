<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => "BBS Rim",
            'description' => fake('BBS')->text(),
            'img_uri' => fake()->imageUrl(640, 480, null, true, 'Rim'),
            'material' => fake()->randomElement(['Metal','Aluminium']),
            'size' => fake()->numberBetween(11, 19),
            'price' => fake()->numberBetween(50,1500),
            'brand_id' => fake()->numberBetween(1,5), 
            'category_id' => fake()->numberBetween(1,5),
        ];
    }
}
