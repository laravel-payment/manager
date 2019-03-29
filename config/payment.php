<?php

return [
    'route' => [
        'domain' => env('PAYMENT_ROUTE_DOMAIN', null),
        'prefix' => env('PAYMENT_ROUTE_PREFIX', 'payment'),
        'as'     => env('PAYMENT_ROUTE_NAME', 'payment.'),
    ],
];
