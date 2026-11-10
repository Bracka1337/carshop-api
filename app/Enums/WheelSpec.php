<?php

namespace App\Enums;

use App\Models\Product;
use Illuminate\Support\Number;

/**
 * Wheel specifications as shown in the shop: one place for labels, units and formats.
 * Cases are in the order of the product page's spec table.
 */
enum WheelSpec: string
{
    case Diameter = 'diameter';
    case Width = 'width';
    case Offset = 'et';
    case CenterBore = 'cb';
    case BoltPattern = 'bolt_pattern';
    case Type = 'type';

    /** The specs shown as chips on catalogue cards. */
    public const KEY = [self::Diameter, self::Width, self::BoltPattern];

    public function label(): string
    {
        return match ($this) {
            self::Diameter => 'Diameter',
            self::Width => 'Width',
            self::Offset => 'Offset',
            self::CenterBore => 'Center bore',
            self::BoltPattern => 'Bolt pattern',
            self::Type => 'Type / material',
        };
    }

    /** Unit shown next to the label in the spec table, or null. */
    public function unit(): ?string
    {
        return match ($this) {
            self::Diameter => 'in',
            self::Width => 'J',
            self::Offset => 'ET, mm',
            self::CenterBore => 'mm',
            self::BoltPattern => 'PCD',
            self::Type => null,
        };
    }

    /** "Offset (ET, mm)" */
    public function labelWithUnit(): string
    {
        return $this->unit() === null ? $this->label() : "{$this->label()} ({$this->unit()})";
    }

    /** Value for the spec table, where the unit is already in the label. */
    public function value(Product $product): string
    {
        return match ($this) {
            self::Diameter => self::number($product->diameter),
            self::Width => self::number($product->width),
            self::Offset => self::number($product->et),
            self::CenterBore => self::number($product->cb),
            self::BoltPattern => self::boltPattern($product),
            self::Type => $product->type,
        };
    }

    /** Compact value for chips and filters: 17″, 8.5J, 5×112. */
    public function short(Product $product): string
    {
        return match ($this) {
            self::Diameter => self::diameter($product->diameter),
            self::Width => self::width($product->width),
            self::Offset => 'ET'.self::number($product->et),
            self::CenterBore => self::number($product->cb).' mm',
            self::BoltPattern => self::boltPattern($product),
            self::Type => $product->type,
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

    private static function boltPattern(Product $product): string
    {
        return $product->bolt.'×'.self::number($product->bolt_diameter);
    }
}
