<?php

namespace Database\Factories;

use App\Models\Delivery_details;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
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
            'status' => fake()->randomElement(['Processing', 'Delivered', 'Delivering', 'Failed']),
            'date' => fake()->date(now()),
            'delivery_details_id' => Delivery_details::factory(),
            'payment_id' => Payment::factory(),
        ];
    }
}
