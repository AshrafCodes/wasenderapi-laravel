<?php

use Ashraf\WasenderApi\Http\Controllers\WasenderWebhookController;
use Illuminate\Support\Facades\Route;

Route::post(config('wasenderapi.webhook_route_path', 'wasenderapi/webhook'), WasenderWebhookController::class)
    ->name('wasenderapi.webhook');
