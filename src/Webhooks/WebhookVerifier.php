<?php

namespace Ashraf\WasenderApi\Webhooks;

use Illuminate\Http\Request;

class WebhookVerifier
{
    public function __construct(protected ?string $secret = null)
    {
        $this->secret ??= config('wasenderapi.webhook_secret');
    }

    public function isValid(Request $request): bool
    {
        if (! $this->secret) {
            return true;
        }

        $signature = $request->header('X-Webhook-Signature');

        return is_string($signature) && hash_equals($this->secret, $signature);
    }
}
