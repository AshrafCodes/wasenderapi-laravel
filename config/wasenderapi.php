<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WasenderAPI Base URL
    |--------------------------------------------------------------------------
    |
    | The public API currently documents endpoints under /api.
    |
    */
    'base_url' => env('WASENDERAPI_BASE_URL', 'https://www.wasenderapi.com/api'),

    /*
    |--------------------------------------------------------------------------
    | Tokens
    |--------------------------------------------------------------------------
    |
    | Use a Personal Access Token for account-level session management and a
    | session API key for session-level messaging endpoints. If only one token is
    | configured, the client will use it as the default bearer token.
    |
    */
    'token' => env('WASENDERAPI_TOKEN', env('WASENDERAPI_API_KEY')),
    'personal_access_token' => env('WASENDERAPI_PERSONAL_ACCESS_TOKEN'),
    'api_key' => env('WASENDERAPI_API_KEY'),

    'timeout' => (int) env('WASENDERAPI_TIMEOUT', 30),
    'retry_times' => (int) env('WASENDERAPI_RETRY_TIMES', 0),
    'retry_sleep' => (int) env('WASENDERAPI_RETRY_SLEEP', 200),
    'throw' => env('WASENDERAPI_THROW', true),
    'include_response_headers' => env('WASENDERAPI_INCLUDE_RESPONSE_HEADERS', false),

    /*
    |--------------------------------------------------------------------------
    | Webhooks
    |--------------------------------------------------------------------------
    |
    | WasenderAPI sends the configured secret in X-Webhook-Signature. Enable the
    | route below if you want the package to receive and dispatch webhooks.
    |
    */
    'webhook_secret' => env('WASENDERAPI_WEBHOOK_SECRET'),
    'webhook_route_enabled' => env('WASENDERAPI_WEBHOOK_ROUTE_ENABLED', true),
    'webhook_route_path' => env('WASENDERAPI_WEBHOOK_ROUTE_PATH', 'wasenderapi/webhook'),
    'webhook_route_middleware' => ['api'],
];
