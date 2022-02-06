<?php

return [
    'base_url' => env('APP_CUSTOMER_LOOKUP'),
    'api_key' => env('CUSTOMER_LOOKUP_KEY'),
    'endpoint' => [
        'verify_email' => '/sc2-admin/customer-service/customer-lookup',
    ],
    'template_dir' => 'checkout'
];
