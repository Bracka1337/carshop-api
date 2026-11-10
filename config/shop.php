<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Storefront
    |--------------------------------------------------------------------------
    |
    | Name and contact details shown in the shop header, footer and titles.
    |
    */

    'name' => env('SHOP_NAME', 'Offset'),

    'contact' => [
        'email' => env('SHOP_EMAIL', 'hello@offset-wheels.test'),
        'phone' => env('SHOP_PHONE', '+371 2204 0687'),
    ],

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

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    |
    | ISO 4217 code (admin tables, API) and the symbol shown on shop pages.
    |
    */

    'currency' => [
        'code' => env('SHOP_CURRENCY', 'EUR'),
        'symbol' => env('SHOP_CURRENCY_SYMBOL', '€'),
    ],

    'vat_rate' => (float) env('SHOP_VAT_RATE', 0.21),

    'shipping' => [
        'rate' => (float) env('SHOP_SHIPPING_RATE', 0.10),
        'free_from' => (float) env('SHOP_FREE_SHIPPING_FROM', 1000),
    ],

];
