<?php

return [
    'default' => [
        'url' => env('PHPIPAM_URL'),
        'user' => env('PHPIPAM_USER'),
        'pass' => env('PHPIPAM_PASSWORD'),
        'app' => env('PHPIPAM_APP'),
        'token' => env('PHPIPAM_TOKEN'),
        'verify_cert' => env('PHPIPAM_VERIFY_CERT', true),
    ],

    //'second_connection' => [
    //    'url' => env('PHPIPAM_2_URL'),
    //    'user' => env('PHPIPAM_2_USER'),
    //    'pass' => env('PHPIPAM_2_PASSWORD'),
    //    'app' => env('PHPIPAM_2_APP'),
    //    'token' => env('PHPIPAM_2_TOKEN'),
    //    'verify_cert' => env('PHPIPAM_2_VERIFY_CERT', true),
    //],
];
