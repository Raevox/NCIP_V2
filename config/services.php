<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'openrouter' => [
        'key' => env('OPENAI_COMPATIBLE_API_KEY', env('OPENROUTER_API_KEY')),
        'url' => env('OPENAI_COMPATIBLE_URL', env('OPENROUTER_URL', 'https://agentrouter.org/v1/chat/completions')),
        'model' => env('OPENAI_COMPATIBLE_MODEL', env('OPENROUTER_MODEL', 'gpt-5.6-sol')),
    ],

    'textbee' => [
        'api_key' => env('TEXTBEE_API_KEY'),
        'api_url' => env('TEXTBEE_API_URL', 'https://api.textbee.dev/api/v1/gateway/send-sms'),
    ],


];
