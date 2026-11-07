<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Shipping
    |--------------------------------------------------------------------------
    |
    | Shipping is a percentage of the order subtotal and is free once the
    | subtotal reaches "free_from". Used by checkout and by saved orders.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | VAT
    |--------------------------------------------------------------------------
    |
    | Product prices include VAT at this rate; totals show the VAT part.
    |
    */

    'vat_rate' => (float) env('SHOP_VAT_RATE', 0.21),

    'shipping' => [
        'rate' => (float) env('SHOP_SHIPPING_RATE', 0.10),
        'free_from' => (float) env('SHOP_FREE_SHIPPING_FROM', 1000),
    ],

];
