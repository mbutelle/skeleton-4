<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Message\Label;

use App\Shared\Infrastructure\Message\MessageInterface;

final class RemoveLabel implements MessageInterface
{
    public string $reference;

    public function __construct(string $reference)
    {
        $this->reference = $reference;
    }
}