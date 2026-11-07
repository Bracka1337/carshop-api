<?php

namespace App\Services;

/**
 * The single shipping rule for the shop: a percentage of the subtotal,
 * free once the subtotal reaches the threshold.
 */
class ShippingCalculator
{
    public function __construct(
        private readonly float $rate,
        private readonly float $freeFrom,
    ) {}

    public static function fromConfig(): self
    {
        return new self(
            (float) config('shop.shipping.rate'),
            (float) config('shop.shipping.free_from'),
        );
    }

    public function cost(float $subtotal): float
    {
        if ($subtotal <= 0 || $subtotal >= $this->freeFrom) {
            return 0.0;
        }

        return round($subtotal * $this->rate, 2);
    }
}
