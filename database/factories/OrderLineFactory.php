<?php

namespace Database\Factories;

use App\Models\OrderLine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderLine>
 */
class OrderLineFactory extends Factory
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
