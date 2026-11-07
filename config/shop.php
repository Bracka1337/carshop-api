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

    'shipping' => [
        'rate' => (float) env('SHOP_SHIPPING_RATE', 0.10),
        'free_from' => (float) env('SHOP_FREE_SHIPPING_FROM', 1000),
    ],

];
