<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http;

use Psr\Http\Message\ResponseInterface as HttpResponse;

final class ExternalResponse implements ResponseInterface
{
    private HttpResponse $response;

    public function __construct(HttpResponse $response)
    {
        $this->response = $response;
    }

    public function getCode(): int
    {
        return $this->response->getStatusCode();
    }

    public function getContent(): string
    {
        return $this->response->getBody()->getContents();
    }
}