<?php

$social_json = file_get_contents('assets/common/json/social.json');
$social_info = json_decode($social_json,true);
/**
 * "google_client_id": "779899859129-p1qrqg25vtd6tp8fbbd0cr3h31as34ne.apps.googleusercontent.com",
    "google_client_secret": "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",
 * "facebook_client_id": "1400509718069645",
    "facebook_client_secret": "b5f261f4a37a40394653b15a604c3306","facebook_client_id": "1400509718069645",
    "facebook_client_secret": "b5f261f4a37a40394653b15a604c3306",
 * "instagram_client_id": "3972614992950681",
    "instagram_client_secret": "6f11fe54eb6b99af85972dc607fec33a"
 */

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

    'google' => [
        'client_id' => $social_info['google_client_id'],
        'client_secret' => $social_info['google_client_secret'],
        'redirect' => $social_info['redirect_base_url'].'/auth/google/callback'
    ],

    'facebook' => [
        'client_id' => $social_info['facebook_client_id'],
        'client_secret' => $social_info['facebook_client_secret'],
        'redirect' => $social_info['redirect_base_url'].'/auth/facebook/callback'
    ],

    'facebook' => [
        'client_id' => $social_info['facebook_client_id'],
        'client_secret' => $social_info['facebook_client_secret'],
        'redirect' => $social_info['redirect_base_url'].'/auth/facebook/callback'
    ],

];
