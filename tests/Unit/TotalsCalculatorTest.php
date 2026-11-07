<?php

namespace Tests\Unit;

use App\Services\ShippingCalculator;
use App\Services\TotalsCalculator;
use PHPUnit\Framework\TestCase;

class TotalsCalculatorTest extends TestCase
{
    private function calculator(): TotalsCalculator
    {
        return new TotalsCalculator(new ShippingCalculator(rate: 0.10, freeFrom: 1000), vatRate: 0.21);
    }

    public function test_vat_is_the_part_of_a_vat_inclusive_price(): void
    {
        $this->assertSame(21.0, $this->calculator()->vatIncluded(121));
        $this->assertSame(100.0, $this->calculator()->withoutVat(121));
    }

    public function test_subtotal_tax_and_shipping_add_up_to_the_total(): void
    {
        $totals = $this->calculator()->forItems(300);

        $this->assertSame(['subtotal' => 247.93, 'tax' => 52.07, 'shipping' => 30.0, 'total' => 330.0], $totals);
        $this->assertSame($totals['total'], round($totals['subtotal'] + $totals['tax'] + $totals['shipping'], 2));
    }
}
