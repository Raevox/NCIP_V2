<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => [ // staff at admin dito lahat
            'driver' => 'session',
            'provider' => 'users',
        ],

        'applicant' => [
            'driver' => 'session',
            'provider' => 'ip_accounts',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'ip_accounts' => [
            'driver' => 'eloquent',
            'model' => App\Models\IpAccount::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    'ip_accounts' => [
        'provider' => 'ip_accounts',
        'table' => 'password_reset_tokens',  
        'expire' => 60,
        'throttle' => 60,
    ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];
