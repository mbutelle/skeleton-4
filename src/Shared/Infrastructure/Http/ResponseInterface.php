<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http;

interface ResponseInterface
{
    public function getCode(): int;
    public function getContent(): string;
}