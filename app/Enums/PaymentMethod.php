<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * How a customer pays, as chosen at checkout and stored in delivery_details.payment_method.
 */
enum PaymentMethod: string implements HasLabel
{
    case CreditCard = 'credit-card';
    case PayOnDelivery = 'pay-on-delivery';

    public function getLabel(): string
    {
        return match ($this) {
            self::CreditCard => 'Credit card',
            self::PayOnDelivery => 'Pay on delivery',
        };
    }
}
