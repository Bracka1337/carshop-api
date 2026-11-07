<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\DeliveryDetail;
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
            'status' => fake()->randomElement(OrderStatus::cases()),
            'date' => fake()->date(now()),
            'delivery_details_id' => DeliveryDetail::factory(),
            'payment_id' => Payment::factory(),
        ];
    }
}
