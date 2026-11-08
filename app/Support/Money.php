<?php

namespace App\Support;

/**
 * Formats amounts in the shop currency from config/shop.php.
 */
final class Money
{
    public static function code(): string
    {
        return (string) config('shop.currency.code');
    }

    public static function symbol(): string
    {
        return (string) config('shop.currency.symbol');
    }

    public static function format(float|int|string $amount, int $decimals = 2): string
    {
        return self::symbol().number_format((float) $amount, $decimals);
    }
}
