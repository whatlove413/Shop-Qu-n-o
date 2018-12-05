<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('sandbox1d0d595e5af540c2b14c4c54e64a848e.mailgun.org'),
        'secret' => env('key-4a5ee5489d938d91d35b1b2bd1dfdad8'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
        'client_id' => '400726177116658',
        'client_secret' => '87a0f2dffd1d6d0930fbf5d370e0e800',
        'redirect' => 'http://sharingeconomy.local.com/dang-nhap/facebook/callback',
    ],

];
