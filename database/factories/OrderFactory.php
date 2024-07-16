<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(['Processing','Delivered', 'Delivering', 'Failed']),
            'date' => fake()->date(now()),
            'delivery_details_id' => \App\Models\Delivery_details::factory(),
            'payment_id' => \App\Models\Payment::factory(),
        ];
    }
}
