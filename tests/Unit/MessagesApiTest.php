<?php

namespace AshrafCodes\WasenderApi\Tests\Unit;

use AshrafCodes\WasenderApi\Facades\WasenderApi;
use AshrafCodes\WasenderApi\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class MessagesApiTest extends TestCase
{
    public function test_it_sends_text_messages(): void
    {
        Http::fake([
            'www.wasenderapi.com/api/send-message' => Http::response(['success' => true], 200),
        ]);

        $response = WasenderApi::messages()->text('+1234567890', 'Hello');

        $this->assertTrue($response['success']);

        Http::assertSent(fn ($request) =>
            $request->url() === 'https://www.wasenderapi.com/api/send-message'
            && $request['to'] === '+1234567890'
            && $request['text'] === 'Hello'
            && $request->hasHeader('Authorization', 'Bearer test-api-key')
        );
    }

    public function test_it_marks_message_as_read(): void
    {
        Http::fake([
            'www.wasenderapi.com/api/messages/read' => Http::response(['success' => true], 200),
        ]);

        WasenderApi::messages()->markAsRead([
            'id' => 'message-id',
            'remoteJid' => '123@s.whatsapp.net',
            'fromMe' => false,
        ]);

        Http::assertSent(fn ($request) =>
            $request->url() === 'https://www.wasenderapi.com/api/messages/read'
            && $request['key']['id'] === 'message-id'
        );
    }
}
