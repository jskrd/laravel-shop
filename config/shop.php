<?php

return [

    'api_path' => '/shop-api',

    'currency' => 'GBP',

    'stripe' => [
        'key' => env('SHOP_STRIPE_KEY'),
        'secret' => env('SHOP_STRIPE_SECRET'),
    ],

];
