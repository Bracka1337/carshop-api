<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    public const NAMES = [
        '885', 'AEZ', 'Alcar HybridRad', 'ALUTEC', 'ATS', 'Autec', 'AVUS', 'Barzetta', 'Borbet', 'BREYTON',
        'BRIDE', 'Brock', 'Carbonado', 'Carmani', 'Carwel', 'CForged', 'CMS', 'DEZENT', 'Diewe Wheels',
        'DOTZ', 'Dotz 4x4', 'Fondmetal', 'Forzza', 'IT WHEELS', 'Jack Wheeler', 'JR WHEELS', 'Keskin Tuning',
        'Magline', 'MAK', 'MAM Leichtmetallräder', 'Melchior', 'MOMO', 'Motec', 'MSW', 'NPK', 'Oxigin',
        'OZ Racing', 'RC-DESIGN', 'Ronal', 'seventy9', 'SPARCO', 'Speedline', 'SRW', 'Tomason', 'TREBL',
        'Wrath Wheels', 'CONCAVER', 'BMW', 'Black Rhino', 'Fuel', 'MW', 'Rial', 'Rotiform', 'Venue',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $index = 0;

        return [
            'title' => self::NAMES[$index++ % count(self::NAMES)],
        ];
    }
}
