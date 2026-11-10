<?php

namespace App\Enums;

use App\Models\Product;
use Illuminate\Support\Number;

/**
 * Wheel specifications as shown in the shop: one place for labels and formats.
 */
enum WheelSpec: string
{
    case Diameter = 'diameter';
    case Width = 'width';
    case BoltPattern = 'bolt_pattern';

    /** The specs shown as chips on catalogue cards. */
    public const KEY = [self::Diameter, self::Width, self::BoltPattern];

    public function label(): string
    {
        return match ($this) {
            self::Diameter => 'Diameter',
            self::Width => 'Width',
            self::BoltPattern => 'Bolt pattern',
        };
    }

    /** Compact value for chips and filters: 17″, 8.5J, 5×112. */
    public function short(Product $product): string
    {
        return match ($this) {
            self::Diameter => self::diameter($product->diameter),
            self::Width => self::width($product->width),
            self::BoltPattern => $product->bolt.'×'.self::number($product->bolt_diameter),
        };
    }

    public static function diameter(float|int|string $inches): string
    {
        return self::number($inches).'″';
    }

    public static function width(float|int|string $width): string
    {
        return self::number($width).'J';
    }

    /** 8.00 → "8", 8.50 → "8.5", 114.30 → "114.3". */
    public static function number(float|int|string $value): string
    {
        return (string) Number::format((float) $value, maxPrecision: 2);
    }
}
