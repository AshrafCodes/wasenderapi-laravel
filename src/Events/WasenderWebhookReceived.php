<?php

namespace AshrafCodes\WasenderApi\Events;

class WasenderWebhookReceived
{
    public function __construct(
        public readonly string $event,
        public readonly array $payload,
        public readonly array $data = [],
    ) {
    }
}
