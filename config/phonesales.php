<?php

return [
    'base_url' => env('MJ_BASE_URL'),
    'api_key' => env('MJ_KEY'),
    'endpoint' => [
        'verify' => '/sc2-admin/fe-payments/check',
        'login' => '/marketing-journey/login',
        'purchase' => '/sc2-admin/fe-payments/process-purchase',
        'email_tnc' => '/sc2-admin/fe-payments/customer-tnc',
        'events' => '/sc2-admin/fe-payments/events',
        'payments' => '/apis/sc2-admin/fe-payments/account/list',
    ],
    'template_dir' => 'checkout'
];
