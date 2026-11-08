<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Image>
 */
class ImageFactory extends Factory
{
    private const IMAGES = [
        'images/885.webp', 'images/Borbet.webp', 'images/AEZ.webp', 'images/Alcar-HybridRad.webp',
        'images/ALUTEC.webp', 'images/ATS.webp', 'images/Autec.webp',
    ];

    /**
     * Define the model's default state.
     *
     * Images are handed out in rotation, so a product's three images differ and
     * neighbouring products don't open with the same picture.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $index = 0;

        return [
            'img_uri' => self::IMAGES[$index++ % count(self::IMAGES)],
        ];
    }
}
