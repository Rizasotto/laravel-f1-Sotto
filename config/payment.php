<?php

return [
    'gcash' => [
        'merchant_id' => env('GCASH_MERCHANT_ID', 'DEMO_MERCHANT_ID'),
        'api_key' => env('GCASH_API_KEY', 'demo_api_key'),
        'merchant_secret' => env('GCASH_MERCHANT_SECRET', 'demo_secret'),
        'sandbox_mode' => env('GCASH_SANDBOX_MODE', true),
    ],
];
