<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [ 
            'status' => fake()->randomElement(['Processing', 'Success', 'Unpaid', 'Failed', 'Refunded']),
            'date' => fake()->date(now()),
        ];
    }
}
