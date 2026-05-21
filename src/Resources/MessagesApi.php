<?php

namespace AshrafCodes\WasenderApi\Resources;

class MessagesApi extends AbstractResource
{
    public function send(array $payload): array
    {
        return $this->client->usingApiKey()->post('send-message', $payload);
    }

    public function text(string $to, string $text, array $extra = []): array
    {
        return $this->send(array_merge($extra, compact('to', 'text')));
    }

    public function image(string $to, string $imageUrl, ?string $text = null, array $extra = []): array
    {
        return $this->send(array_filter(array_merge($extra, compact('to', 'text', 'imageUrl')), fn ($value) => $value !== null));
    }

    public function video(string $to, string $videoUrl, ?string $text = null, array $extra = []): array
    {
        return $this->send(array_filter(array_merge($extra, compact('to', 'text', 'videoUrl')), fn ($value) => $value !== null));
    }

    public function document(string $to, string $documentUrl, ?string $text = null, ?string $fileName = null, array $extra = []): array
    {
        return $this->send(array_filter(array_merge($extra, compact('to', 'text', 'documentUrl', 'fileName')), fn ($value) => $value !== null));
    }

    public function audio(string $to, string $audioUrl, array $extra = []): array
    {
        return $this->send(array_merge($extra, compact('to', 'audioUrl')));
    }

    public function sticker(string $to, string $stickerUrl, array $extra = []): array
    {
        return $this->send(array_merge($extra, compact('to', 'stickerUrl')));
    }

    public function contactCard(string $to, array $contact, array $extra = []): array
    {
        return $this->send(array_merge($extra, compact('to', 'contact')));
    }

    public function location(string $to, float $latitude, float $longitude, ?string $name = null, ?string $address = null, array $extra = []): array
    {
        $location = array_filter(compact('latitude', 'longitude', 'name', 'address'), fn ($value) => $value !== null);

        return $this->send(array_merge($extra, compact('to', 'location')));
    }

    public function poll(string $to, string $question, array $options, bool $multiSelect = false, array $extra = []): array
    {
        return $this->send(array_merge($extra, [
            'to' => $to,
            'poll' => compact('question', 'options', 'multiSelect'),
        ]));
    }

    public function quoted(string $to, string $text, array $quoted, array $extra = []): array
    {
        return $this->send(array_merge($extra, compact('to', 'text', 'quoted')));
    }

    public function withMentions(string $to, string $text, array $mentions, array $extra = []): array
    {
        return $this->send(array_merge($extra, compact('to', 'text', 'mentions')));
    }

    public function viewOnce(string $to, array $media, array $extra = []): array
    {
        return $this->send(array_merge($extra, $media, [
            'to' => $to,
            'viewOnce' => true,
        ]));
    }

    public function resend(string|int $message): array
    {
        return $this->client->usingApiKey()->post("messages/{$message}/resend");
    }

    public function edit(string $messageId, string $text, array $extra = []): array
    {
        return $this->client->usingApiKey()->put("messages/{$messageId}", array_merge($extra, compact('text')));
    }

    public function info(string $messageId): array
    {
        return $this->client->usingApiKey()->get("messages/{$messageId}/info");
    }

    public function delete(string $messageId, array $payload = []): array
    {
        return $this->client->usingApiKey()->delete("messages/{$messageId}", $payload);
    }

    public function markAsRead(array $key): array
    {
        return $this->client->usingApiKey()->post('messages/read', compact('key'));
    }

    public function decryptMedia(array $messageData): array
    {
        return $this->client->usingApiKey()->post('decrypt-media', ['data' => $messageData]);
    }

    public function uploadBase64(string $base64, ?string $mimetype = null): array
    {
        return $this->client->usingApiKey()->post('upload', array_filter(compact('base64', 'mimetype'), fn ($value) => $value !== null));
    }

    public function uploadBinary(string $path, string $mimetype): array
    {
        return $this->client->usingApiKey()->postRaw('upload', fopen($path, 'r'), $mimetype);
    }
}
