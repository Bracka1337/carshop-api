<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    private const MODELS = [
        'Apex', 'Atlas', 'Blade', 'Corsa', 'Delta', 'Drift', 'Helix', 'Kestrel', 'Matrix', 'Monza',
        'Nordic', 'Rally', 'Rebel', 'Ridge', 'Strada', 'Summit', 'Titan', 'Torque', 'Vector', 'Vortex',
    ];

    private const WIDTHS = [4.00, 4.50, 5.00, 5.50, 6.00, 6.50, 7.00, 7.25, 7.50, 8.00, 8.25, 8.50, 9.00, 9.50, 10.00, 10.50, 11.00, 11.50, 12.00];

    private const ALLOY_BUILDS = ['Cast', 'Low-pressure cast', 'Flow-formed', 'Forged'];

    private const ALLOY_FINISHES = [
        'gloss black', 'matte black', 'hyper silver', 'gunmetal grey', 'satin bronze',
        'gloss black with a diamond-cut face', 'brushed aluminium under a clear coat', 'satin titanium',
    ];

    private const ALLOY_DESIGNS = [
        'Concave five-spoke design', 'Split ten-spoke design', 'Multi-spoke mesh design',
        'Y-spoke design with a deep lip', 'Twin five-spoke design', 'Six-spoke design for larger brakes',
    ];

    private const STEEL_FINISHES = ['black powder-coat', 'silver paint', 'black e-coat'];

    private const CLOSINGS = [
        'Hub-centric rings may be needed for an exact centre-bore fit.',
        'Check your vehicle\'s bolt pattern and offset before ordering.',
        'Clear-coated against road salt and brake dust.',
        'Suitable for summer and winter tyres.',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $diameter = fake()->numberBetween(13, 22);
        // Keep the rim width plausible for the diameter (about 0.3–0.6 of it).
        $width = fake()->randomElement(array_values(array_filter(
            self::WIDTHS,
            fn (float $w) => $w >= $diameter * 0.3 && $w <= $diameter * 0.6
        )));
        $type = fake()->randomElement(['Alloy', 'Steel']);
        $bolt = fake()->randomElement([4, 5, 6]);
        $boltDiameter = fake()->randomElement([98.00, 100.00, 105.00, 108.00, 110.00, 112.00, 114.30, 115.00, 118.00, 120.00, 125.00, 127.00, 130.00, 139.70, 160.00]);
        $et = fake()->randomElement([-20, -12, 0, 10, 15, 18, 20, 23.5, 25, 28, 30, 31.5, 33, 35, 35.5, 37, 38, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 52, 53, 55]);
        $cb = fake()->randomElement([54.10, 56.10, 56.60, 57.10, 58.10, 60.10, 63.40, 64.10, 65.10, 66.10, 66.60, 67.10, 70.10, 71.60, 72.60, 74.10, 78.10, 93.10, 106.10, 108.10]);

        return [
            'brand_id' => fn () => Brand::inRandomOrder()->value('id') ?? Brand::factory(),
            'title' => fn (array $attributes) => sprintf(
                '%s %s %dx%s',
                Brand::whereKey($attributes['brand_id'])->value('title'),
                fake()->randomElement(self::MODELS),
                $diameter,
                self::number($width),
            ),
            'description' => $this->describe($type, $bolt, $boltDiameter, $et, $cb),
            'diameter' => $diameter,
            'width' => $width,
            'et' => $et,
            'bolt' => $bolt,
            'bolt_diameter' => $boltDiameter,
            'type' => $type,
            'cb' => $cb,
            'price' => $type === 'Steel' ? fake()->numberBetween(50, 180) : fake()->numberBetween(150, 1500),
        ];
    }

    private function describe(string $type, int $bolt, float $boltDiameter, float $et, float $cb): string
    {
        $intro = $type === 'Steel'
            ? sprintf('Pressed steel wheel with a %s finish. A tough, easy-to-repair choice for winter tyres.', fake()->randomElement(self::STEEL_FINISHES))
            : sprintf(
                '%s aluminium alloy wheel in %s. %s.',
                fake()->randomElement(self::ALLOY_BUILDS),
                fake()->randomElement(self::ALLOY_FINISHES),
                fake()->randomElement(self::ALLOY_DESIGNS),
            );

        return sprintf(
            '%s Fitment: %dx%s bolt pattern, ET%s offset, %s mm centre bore. %s',
            $intro,
            $bolt,
            self::number($boltDiameter),
            self::number($et),
            self::number($cb),
            // The clear-coat line only fits alloys.
            fake()->randomElement($type === 'Steel' ? array_slice(self::CLOSINGS, 0, 2) : self::CLOSINGS),
        );
    }

    /** 8.00 → "8", 8.50 → "8.5", 114.30 → "114.3". */
    private static function number(float $value): string
    {
        return rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.');
    }
}
