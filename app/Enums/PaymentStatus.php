<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

/**
 * Status of an order's payment. Values are the strings stored in payments.status.
 */
enum PaymentStatus: string implements HasColor, HasLabel
{
    case Processing = 'Processing';
    case Unpaid = 'Unpaid';
    case Success = 'Success';
    case Failed = 'Failed';
    case Refunded = 'Refunded';

    public function getLabel(): string
    {
        return $this->value;
    }

    /** Badge colour in the admin panel. */
    public function getColor(): string
    {
        return match ($this) {
            self::Processing => 'gray',
            self::Unpaid, self::Refunded => 'warning',
            self::Success => 'success',
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
            self::Processing, self::Unpaid => ['bg-yellow-200', 'text-yellow-600'],
            self::Success => ['bg-green-200', 'text-green-600'],
            self::Failed => ['bg-red-200', 'text-gray-600'],
            self::Refunded => ['bg-red-200', 'text-red-600'],
        };
    }
}
