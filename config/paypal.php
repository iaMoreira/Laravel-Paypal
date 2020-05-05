<?php


return [
    'client_id' => env('PAYPAL_CLIENT_ID'),
    'secret_id' => env('PAYPAL_SECRET_ID'),

    'settings' => [
        'mode' => 'sandbox',
        'http.ConnectionTimeout' => 30,
        'log.logEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'FINE'
    ]
];
