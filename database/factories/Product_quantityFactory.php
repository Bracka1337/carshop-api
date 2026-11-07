<?php

namespace Database\Factories;

use App\Models\Product_quantity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product_quantity>
 */
class Product_quantityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => fake()->numberBetween(1, 10),
            'product_id' => fake()->numberBetween(1, 200),
        ];
    }
}
