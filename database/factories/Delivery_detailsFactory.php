<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Delivery_detailsFactory extends Factory
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
            'payment_method' => fake()->randomElement(['Credit Card','Pay on delivery']),
            'delivery_method' => fake()-> randomElement(['DPD','Venipak']),
        ];
    }
}