<?php return [
    'url' => env('SALESFORCE_URL'),
    'username' => env('SALESFORCE_USERNAME'),
    'password' => env('SALESFORCE_PASSWORD'),
    'security_token' => env('SALESFORCE_SECURITY_TOKEN'),
    'client_id' => env('SALESFORCE_CLIENT_ID'),
    'client_secret' => env('SALESFORCE_CLIENT_SECRET'),

    // Default subscription combi product in Salesforce
    'default_subscription' => env('SALESFORCE_DEFAULT_SUBSCRIPTION', 'a072X00001DUj6j'),

    // Session timeout (in minutes) - this is how long the Salesforce access token will remain
    // valid for
    'session_timeout' => env('SALESFORCE_SESSION_TIMEOUT', 60),
];
