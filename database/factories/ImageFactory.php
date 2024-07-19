<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'img_uri' => fake()->randomElement(
                ['images/885.webp', 'images/Borbet.webp', 'images/AEZ.webp', 'images/Alcar-HybridRad.webp', 'images/ALUTEC.webp', 'images/ATS.webp', 'images/Autec.webp']),
        ];
    }
}
