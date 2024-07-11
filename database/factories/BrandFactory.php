<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $index = 0;
        
        $brands = [
            '885', 'AEZ', 'Alcar HybridRad', 'ALUTEC', 'ATS', 'Autec', 'AVUS', 'Barzetta', 'Borbet', 'BREYTON', 
            'BRIDE', 'Brock', 'Carbonado', 'Carmani', 'Carwel', 'CForged', 'CMS', 'DEZENT', 'Diewe Wheels', 
            'DOTZ', 'Dotz 4x4', 'Fondmetal', 'Forzza', 'IT WHEELS', 'Jack Wheeler', 'JR WHEELS', 'Keskin Tuning', 
            'KFZ', 'KiK', 'Magline', 'MAK', 'MAM Leichtmetallräder', 'Melchior', 'MOMO', 'Motec', 'MSW', 
            'Nano', 'NPK', 'OE', 'Oxigin', 'OZ Racing', 'RC-DESIGN', 'Reds', 'Ronal', 'seventy9', 'SONAX', 
            'SPARCO', 'Speedline', 'SRW', 'Tomason', 'TREBL', 'Wrath Wheels', 'CONCAVER', 'BMW', 'Black Rhino', 
            'Fuel', 'GG', 'MW', 'RC Design', 'Rial', 'Rotiform', 'Venue'
        ];

        return [
            'title' => $brands[$index++],
        ];
    }
}
