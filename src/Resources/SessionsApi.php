<?php

namespace Ashraf\WasenderApi\Resources;

class SessionsApi extends AbstractResource
{
    public function all(array $query = []): array
    {
        return $this->client->usingPersonalAccessToken()->get('whatsapp-sessions', $query);
    }

    public function create(array $payload): array
    {
        return $this->client->usingPersonalAccessToken()->post('whatsapp-sessions', $payload);
    }

    public function get(string|int $session): array
    {
        return $this->client->usingPersonalAccessToken()->get("whatsapp-sessions/{$session}");
    }

    public function update(string|int $session, array $payload): array
    {
        return $this->client->usingPersonalAccessToken()->put("whatsapp-sessions/{$session}", $payload);
    }

    public function delete(string|int $session): array
    {
        return $this->client->usingPersonalAccessToken()->delete("whatsapp-sessions/{$session}");
    }

    public function restart(string|int $session): array
    {
        return $this->client->usingPersonalAccessToken()->post("whatsapp-sessions/{$session}/restart");
    }

    public function connect(string|int $session): array
    {
        return $this->client->usingPersonalAccessToken()->post("whatsapp-sessions/{$session}/connect");
    }

    public function disconnect(string|int $session): array
    {
        return $this->client->usingPersonalAccessToken()->post("whatsapp-sessions/{$session}/disconnect");
    }

    public function messageLogs(string|int $session, array $query = []): array
    {
        return $this->client->usingPersonalAccessToken()->get("whatsapp-sessions/{$session}/message-logs", $query);
    }

    public function qrCode(string|int $session): array
    {
        return $this->client->usingPersonalAccessToken()->get("whatsapp-sessions/{$session}/qrcode");
    }

    public function logs(string|int $session, array $query = []): array
    {
        return $this->client->usingPersonalAccessToken()->get("whatsapp-sessions/{$session}/session-logs", $query);
    }

    public function regenerateApiKey(string|int $session): array
    {
        return $this->client->usingPersonalAccessToken()->post("whatsapp-sessions/{$session}/regenerate-key");
    }

    public function status(): array
    {
        return $this->client->usingApiKey()->get('status');
    }

    public function user(): array
    {
        return $this->client->usingApiKey()->get('user');
    }

    public function isOnWhatsApp(string $phoneNumber): array
    {
        return $this->client->usingApiKey()->get('on-whatsapp/' . rawurlencode($phoneNumber));
    }

    public function sendPresenceUpdate(string $jid, string $presence, array $extra = []): array
    {
        return $this->client->usingApiKey()->post('send-presence-update', array_merge($extra, [
            'to' => $jid,
            'presence' => $presence,
        ]));
    }
}
