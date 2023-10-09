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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'secret_id' => env('PAYPAL_SECRET_CODE'),
        'currency' => env('PAYMENT_CURRENCY', 'AUD'),
        'testing' => env('PAYPAL_TESTING_MODE', 'true'),
    ],

    'zippay' => [
        'api_key' => env('ZIP_API_KEY'),
        'username' => env('ZIP_USERNAME'),
        'password' => env('ZIP_PASSWORD'),
        'base_url' => env('ZIP_BASE_URL'),
    ],

];
