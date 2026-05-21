<?php

namespace Ashraf\WasenderApi\Http\Controllers;

use Ashraf\WasenderApi\Events\WasenderWebhookReceived;
use Ashraf\WasenderApi\Webhooks\WebhookVerifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WasenderWebhookController extends Controller
{
    public function __invoke(Request $request, WebhookVerifier $verifier): JsonResponse
    {
        if (! $verifier->isValid($request)) {
            return response()->json(['message' => 'Invalid WasenderAPI webhook signature.'], 401);
        }

        $payload = $request->all();

        event(new WasenderWebhookReceived(
            (string) ($payload['event'] ?? 'unknown'),
            $payload,
            is_array($payload['data'] ?? null) ? $payload['data'] : [],
        ));

        return response()->json(['received' => true]);
    }
}
