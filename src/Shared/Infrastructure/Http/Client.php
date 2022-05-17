<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Client
{
    private HttpClientInterface $client;
    private HttpKernelInterface $httpKernel;

    public function __construct(HttpClientInterface $client, HttpKernelInterface $httpKernel, string $internalBaseUri)
    {
        $this->client = $client->withOptions([
            'base_uri' => $internalBaseUri
        ]);

        $this->httpKernel = $httpKernel;
    }

    public function get(string $url, array $queryParameters = [], bool $internalCall = false): ResponseInterface
    {
        if (!$internalCall) {
            return new ExternalResponse($this->client->request('GET', $url));
        }

        $request = Request::create($url, Request::METHOD_GET, $queryParameters);
        return new InternalResponse(
            $this->httpKernel->handle($request, HttpKernelInterface::SUB_REQUEST)
        );
    }
}