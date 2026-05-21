<?php

namespace Ashraf\WasenderApi\Exceptions;

use Exception;
use Illuminate\Http\Client\Response;

class WasenderApiException extends Exception
{
    public function __construct(
        string $message,
        public readonly ?int $status = null,
        public readonly ?array $response = null,
    ) {
        parent::__construct($message, $status ?? 0);
    }

    public static function fromResponse(Response $response): self
    {
        $json = $response->json();
        $message = is_array($json)
            ? (string) ($json['message'] ?? $json['error'] ?? $response->body())
            : $response->body();

        return new self($message ?: 'WasenderAPI request failed.', $response->status(), is_array($json) ? $json : null);
    }
}
