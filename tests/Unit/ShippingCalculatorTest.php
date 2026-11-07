<?php

namespace Tests\Unit;

use App\Services\ShippingCalculator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ShippingCalculatorTest extends TestCase
{
    /**
     * @return array<string, array{float, float}>
     */
    public static function subtotals(): array
    {
        return [
            'below the threshold' => [300, 30],
            'just below the threshold' => [999.99, 100],
            'exactly the threshold' => [1000, 0],
            'above the threshold' => [1200, 0],
            'empty order' => [0, 0],
        ];
    }

    #[DataProvider('subtotals')]
    public function test_shipping_is_a_percentage_until_the_free_threshold(float $subtotal, float $expected): void
    {
        $calculator = new ShippingCalculator(rate: 0.10, freeFrom: 1000);

        $this->assertSame((float) $expected, $calculator->cost($subtotal));
    }
}
