<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * Delivery option chosen at checkout, stored in delivery_details.delivery_method.
 */
enum DeliveryMethod: string implements HasLabel
{
    case Dhl = 'dhl';
    case Express = 'express';

    public function getLabel(): string
    {
        return match ($this) {
            self::Dhl => 'DHL',
            self::Express => 'Express',
        };
    }
}
