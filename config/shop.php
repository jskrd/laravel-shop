<?php

return [

    'api_path' => '/shop-api',

    'currency' => 'GBP',

    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

];
