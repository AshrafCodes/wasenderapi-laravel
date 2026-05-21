<?php

namespace AshrafCodes\WasenderApi\Tests\Unit;

use AshrafCodes\WasenderApi\Facades\WasenderApi;
use AshrafCodes\WasenderApi\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class SessionsApiTest extends TestCase
{
    public function test_session_management_uses_personal_access_token(): void
    {
        Http::fake([
            'www.wasenderapi.com/api/whatsapp-sessions' => Http::response(['success' => true], 200),
        ]);

        WasenderApi::sessions()->all();

        Http::assertSent(fn ($request) =>
            $request->url() === 'https://www.wasenderapi.com/api/whatsapp-sessions'
            && $request->hasHeader('Authorization', 'Bearer test-pat')
        );
    }
}
