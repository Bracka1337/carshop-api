<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement(["Platin", "2drv", "ADR", "Advanti", "AEZ", "Alcar", "Alutec", "Arbex", "ATS", "Autec", "AVUS", "Axxion", "BBS", "Borbet", "BROCK", "Carmani", "Carwel", "CMS", "Concaver", "Dezent", "Diesel", "DOTZ", "Elite Wheels", "Enkei", "ETA-BETA", "Fondmetal", "GMP", "iFree", "Inter Action", "it wheels", "Japan Racing", "Keskin Wheels", "KFZ", "KiK", "Kronprinz", "League", "LegeArtis", "MAK", "MAM", "Meisterwerk", "Momo", "Monaco", "MSW", "Mwd", "MW", "Mille Miglia", "OE", "Oxigin", "OXXO", "OZ", "RC Design", "Reds", "Replay", "RIAL", "Ronal", "Soleil", "Sparco", "Speedline", "Tomason", "Wheelworld", "WSP Italy", "Breyton", "Nano", "Rotiform", "Venue"]),
            'description' => fake('BBS')->text(),
            'preview_img_uri' => fake()->imageUrl(640, 480, null, true, 'Rim'),
            'diameter' => fake()->numberBetween(13, 22),
            'width' => fake()->randomElement(["0", "4.00", "4.50", "5.00", "5.50", "6.00", "6.50", "7.00", "7.25", "7.50", "8.00", "8.25", "8.50", "9.00", "9.50", "10.00", "10.50", "11.00", "11.50", "12.00"]),
            'et' => fake()->randomElement(["0", "-44", "-35", "-32", "-30", "-20", "-15", "-13", "-12", "-10", "-1", "0", "5", "8", "10", "11", "12", "13", "14", "15", "16", "18", "19", "20", "21", "22", "23", "23.5", "24", "25", "26", "27", "28", "29", "30", "31", "31.5", "32", "33", "34", "34.5", "35", "35.5", "36", "36.5", "37", "37.5", "38", "38.5", "39", "39.5", "40", "40.5", "41", "41.5", "42", "42.5", "43", "43.5", "44", "44.5", "45", "46", "47", "47.5", "48", "48.5", "49", "49.5", "50", "50.5", "51", "52", "52.5", "53", "53.5", "54", "54.5", "55", "55.5", "56", "56.4", "57", "58", "59", "60", "61", "62", "62.6", "63", "64", "65", "66", "67"]),
            'bolt' => fake()->randomElement(["0","3", "4", "5", "6"]),
            'bolt_diameter' => fake()->randomElement(["0", "98.00", "100.00", "105.00",  "108.00", "110.00",  "112.00", "114.30", "115.00", "118.00", "120.00", "125.00", "127.00", "130.00", "135.00", "139.00",  "139.70", "140.00", "150.00", "160.00", "165.00", "170.00", "180.00", "200.00", "205.00"]),
            'type' => fake()->randomElement(['Alloy', 'Steel']),
            'cb' => fake()->randomElement([0, 54.00, 54.10, 55.10, 56.00, 56.10, 56.50, 56.60, 57.00, 57.10, 57.60, 58.00, 58.10, 60.00, 60.10, 61.10, 63.00, 63.10, 63.30, 63.40, 64.00, 64.10, 64.20, 65.00, 65.06, 65.10, 66.00, 66.10, 66.40, 66.45, 66.50, 66.505, 66.55, 66.60, 66.70, 67.00, 67.10, 67.20, 68.00, 68.10, 69.10, 70.00, 70.10, 70.20, 70.30, 70.50, 70.60, 70.70, 71.00, 71.10, 71.50, 71.60, 72.00, 72.10, 72.30, 72.50, 72.60, 73.00, 73.10, 74.00, 74.1, 74.10, 75.00, 75.10, 76.00, 76.10, 76.90, 78.10, 79.00, 79.10, 82.00, 82.10, 84.00, 84.10, 89.10, 92.10, 92.40, 93.00, 93.10, 95.50, 100.00, 100.10, 106.00, 106.10, 108.10, 108.30, 110.00, 110.10, 114.00, 130.10, 161.10]),
            'price' => fake()->numberBetween(50,1500),
            'brand_id' => fake()->numberBetween(1,5), 
        ];
    }
}
