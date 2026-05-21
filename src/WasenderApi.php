<?php

namespace AshrafCodes\WasenderApi;

use AshrafCodes\WasenderApi\Resources\ChannelsApi;
use AshrafCodes\WasenderApi\Resources\ContactsApi;
use AshrafCodes\WasenderApi\Resources\GroupsApi;
use AshrafCodes\WasenderApi\Resources\MessagesApi;
use AshrafCodes\WasenderApi\Resources\SessionsApi;

class WasenderApi
{
    public function __construct(protected Client $client)
    {
    }

    public function withToken(string $token): self
    {
        return new self($this->client->withToken($token));
    }

    public function usingPersonalAccessToken(): self
    {
        return new self($this->client->usingPersonalAccessToken());
    }

    public function usingApiKey(): self
    {
        return new self($this->client->usingApiKey());
    }

    public function client(): Client
    {
        return $this->client;
    }

    public function sessions(): SessionsApi
    {
        return new SessionsApi($this->client);
    }

    public function messages(): MessagesApi
    {
        return new MessagesApi($this->client);
    }

    public function contacts(): ContactsApi
    {
        return new ContactsApi($this->client);
    }

    public function groups(): GroupsApi
    {
        return new GroupsApi($this->client);
    }

    public function channels(): ChannelsApi
    {
        return new ChannelsApi($this->client);
    }

    public function get(string $endpoint, array $query = []): array
    {
        return $this->client->get($endpoint, $query);
    }

    public function post(string $endpoint, array $payload = []): array
    {
        return $this->client->post($endpoint, $payload);
    }

    public function put(string $endpoint, array $payload = []): array
    {
        return $this->client->put($endpoint, $payload);
    }

    public function delete(string $endpoint, array $payload = []): array
    {
        return $this->client->delete($endpoint, $payload);
    }
}
