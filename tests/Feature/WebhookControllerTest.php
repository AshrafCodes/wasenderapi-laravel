<?php

namespace AshrafCodes\WasenderApi\Tests\Feature;

use AshrafCodes\WasenderApi\Events\WasenderWebhookReceived;
use AshrafCodes\WasenderApi\Tests\TestCase;
use Illuminate\Support\Facades\Event;

class WebhookControllerTest extends TestCase
{
    public function test_it_dispatches_verified_webhooks(): void
    {
        Event::fake();

        $this->postJson('/wasenderapi/webhook', [
            'event' => 'messages.received',
            'data' => ['messageBody' => 'Hello'],
        ], ['X-Webhook-Signature' => 'secret'])->assertOk();

        Event::assertDispatched(WasenderWebhookReceived::class, fn ($event) =>
            $event->event === 'messages.received'
            && $event->data['messageBody'] === 'Hello'
        );
    }

    public function test_it_rejects_invalid_webhook_signature(): void
    {
        $this->postJson('/wasenderapi/webhook', [
            'event' => 'messages.received',
        ], ['X-Webhook-Signature' => 'wrong'])->assertUnauthorized();
    }
}
