<?php

namespace AshrafCodes\WasenderApi\Resources;

class ChannelsApi extends AbstractResource
{
    public function sendMessage(string $channelJid, string $text, array $extra = []): array
    {
        return $this->client->usingApiKey()->post('send-message', array_merge($extra, [
            'to' => $channelJid,
            'text' => $text,
        ]));
    }

    public function send(array $payload): array
    {
        return $this->client->usingApiKey()->post('send-message', $payload);
    }
}
