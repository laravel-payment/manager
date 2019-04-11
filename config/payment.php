<?php

return [
    'table_prefix' => env('PAYMENT_TABLE_PREFIX', 'ps_'),
    'url'          => [
        'success' => '/',
        'fail'    => '/',
    ],
    'route'        => [
        'domain'     => env('PAYMENT_ROUTE_DOMAIN', null),
        'prefix'     => env('PAYMENT_ROUTE_PREFIX', 'payment'),
        'as'         => env('PAYMENT_ROUTE_NAME', 'payment.'),
        'middleware' => ['web'],
    ],
    'services'     => [
//        'sberbank' => [
//            'username'  => env("SBERBANK_USERNAME"),
//            'password'  => env("SBERBANK_PASSWORD"),
//            'test_mode' => true,
//        ],
    ],
];
