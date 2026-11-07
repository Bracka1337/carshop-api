<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Image>
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
            'img_uri' => fake()->randomElement(['images/885.webp', 'images/Borbet.webp', 'images/AEZ.webp', 'images/Alcar-HybridRad.webp', 'images/ALUTEC.webp', 'images/ATS.webp', 'images/Autec.webp']),
        ];
    }
}
