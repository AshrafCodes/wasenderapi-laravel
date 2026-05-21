<?php

namespace Ashraf\WasenderApi;

use Ashraf\WasenderApi\Exceptions\WasenderApiException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Client
{
    public function __construct(
        protected array $config,
        protected ?string $token = null,
    ) {
        $this->token ??= $config['token'] ?? null;
    }

    public function withToken(?string $token): self
    {
        return new self($this->config, $token);
    }

    public function usingPersonalAccessToken(): self
    {
        return $this->withToken($this->config['personal_access_token'] ?? $this->token);
    }

    public function usingApiKey(): self
    {
        return $this->withToken($this->config['api_key'] ?? $this->token);
    }

    public function get(string $endpoint, array $query = []): array
    {
        return $this->send('get', $endpoint, $query);
    }

    public function post(string $endpoint, array $payload = []): array
    {
        return $this->send('post', $endpoint, $payload);
    }

    public function put(string $endpoint, array $payload = []): array
    {
        return $this->send('put', $endpoint, $payload);
    }

    public function delete(string $endpoint, array $payload = []): array
    {
        return $this->send('delete', $endpoint, $payload);
    }

    public function postRaw(string $endpoint, mixed $body, string $contentType): array
    {
        $response = $this->request()
            ->withBody($body, $contentType)
            ->post($this->endpoint($endpoint));

        return $this->decode($response);
    }

    protected function send(string $method, string $endpoint, array $data = []): array
    {
        $response = match ($method) {
            'get' => $this->request()->get($this->endpoint($endpoint), $data),
            'delete' => $this->request()->delete($this->endpoint($endpoint), $data),
            default => $this->request()->{$method}($this->endpoint($endpoint), $data),
        };

        return $this->decode($response);
    }

    protected function request(): PendingRequest
    {
        $request = Http::baseUrl(rtrim((string) $this->config['base_url'], '/'))
            ->acceptJson()
            ->timeout((int) $this->config['timeout']);

        if (($this->config['retry_times'] ?? 0) > 0) {
            $request = $request->retry((int) $this->config['retry_times'], (int) $this->config['retry_sleep']);
        }

        if ($this->token) {
            $request = $request->withToken($this->token);
        }

        return $request;
    }

    protected function decode(Response $response): array
    {
        if ($response->failed() && ($this->config['throw'] ?? true)) {
            throw WasenderApiException::fromResponse($response);
        }

        $data = $response->json();
        $payload = is_array($data) ? $data : ['body' => $response->body()];

        if ($this->config['include_response_headers'] ?? false) {
            $payload['_headers'] = $response->headers();
            $payload['_status'] = $response->status();
        }

        return $payload;
    }

    protected function endpoint(string $endpoint): string
    {
        $endpoint = ltrim($endpoint, '/');

        return str_starts_with($endpoint, 'api/')
            ? substr($endpoint, 4)
            : $endpoint;
    }
}
