<?php

namespace App\Services;

/**
 * Order and cart totals. Product prices include VAT, so the VAT shown is the
 * part of the price that is tax: gross × rate / (1 + rate).
 *
 * "subtotal" is the items total without VAT; subtotal + tax + shipping = total.
 */
class TotalsCalculator
{
    public function __construct(
        private readonly ShippingCalculator $shipping,
        private readonly float $vatRate,
    ) {}

    public static function fromConfig(ShippingCalculator $shipping): self
    {
        return new self($shipping, (float) config('shop.vat_rate'));
    }

    /** The VAT contained in a VAT-inclusive amount. */
    public function vatIncluded(float $gross): float
    {
        return round($gross * $this->vatRate / (1 + $this->vatRate), 2);
    }

    /** A VAT-inclusive amount without its VAT. */
    public function withoutVat(float $gross): float
    {
        return round($gross - $this->vatIncluded($gross), 2);
    }

    /**
     * @param  float  $itemsTotal  sum of the line totals, VAT included
     * @return array{subtotal: float, tax: float, shipping: float, total: float}
     */
    public function forItems(float $itemsTotal): array
    {
        $tax = $this->vatIncluded($itemsTotal);
        $shipping = $this->shipping->cost($itemsTotal);

        return [
            'subtotal' => round($itemsTotal - $tax, 2),
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => round($itemsTotal + $shipping, 2),
        ];
    }
}
