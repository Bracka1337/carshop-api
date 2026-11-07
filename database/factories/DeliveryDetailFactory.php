<?php

namespace Database\Factories;

use App\Enums\DeliveryMethod;
use App\Enums\PaymentMethod;
use App\Models\DeliveryDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DeliveryDetail>
 */
class DeliveryDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'f_name' => fake()->firstName(),
            'l_name' => fake()->lastName(),
            'addr_line_1' => fake()->streetAddress(),
            'country' => fake()->randomElement(['EST', 'LV', 'LT']),
            'payment_method' => fake()->randomElement(PaymentMethod::cases())->value,
            'delivery_method' => fake()->randomElement(DeliveryMethod::cases())->value,
        ];
    }
}
