<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'firebase' => [
        'api_key'        => 'AIzaSyBxTNqzKn2Xjf2h-vyWcYaS9mVEzc4VaGI', // Only used for JS integration
        'auth_domain'    => 'refugio-d50d1.firebaseapp.com', // Only used for JS integration
        'database_url'   => 'https://refugio-d50d1.firebaseio.com',
        'storage_bucket' => 'refugio-d50d1.appspot.com', // Only used for JS integration
    ]

];
