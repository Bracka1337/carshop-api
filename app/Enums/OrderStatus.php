<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

/**
 * Delivery status of an order. Values are the strings stored in orders.status.
 */
enum OrderStatus: string implements HasColor, HasLabel
{
    case Processing = 'Processing';
    case Pending = 'Pending';
    case Delivering = 'Delivering';
    case Delivered = 'Delivered';
    case Failed = 'Failed';

    public function getLabel(): string
    {
        return $this->value;
    }

    /** Badge colour in the admin panel. */
    public function getColor(): string
    {
        return match ($this) {
            self::Processing => 'gray',
            self::Pending => 'warning',
            self::Delivering => 'warning',
            self::Delivered => 'success',
            self::Failed => 'danger',
        };
    }

    /**
     * Tailwind background and text classes for the shop's status badge.
     *
     * @return array{string, string}
     */
    public function badgeClasses(): array
    {
        return match ($this) {
            self::Processing, self::Pending => ['bg-yellow-200', 'text-yellow-600'],
            self::Delivering => ['bg-blue-200', 'text-blue-600'],
            self::Delivered => ['bg-green-200', 'text-green-600'],
            self::Failed => ['bg-red-200', 'text-red-600'],
        };
    }
}
