<?php

return [
    'account_id' => env('ZOOM_ACCOUNT_ID'),
    'client_id' => env('ZOOM_CLIENT_ID'),
    'client_secret' => env('ZOOM_CLIENT_SECRET'),
    'cache_token' => env('ZOOM_CACHE_TOKEN', true),
    'base_url' => 'https://api.zoom.us/v2/',
    'authentication_method' => 'Oauth', // OAuth for server-to-server
    'max_api_calls_per_request' => '5'
];



