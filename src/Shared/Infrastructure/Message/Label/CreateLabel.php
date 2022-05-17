<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Message\Label;

use App\Shared\Infrastructure\Message\MessageInterface;

final class CreateLabel implements MessageInterface
{
    public string $reference;
    public string $productReference;
    public string $format;
    public array $metadata;

    public function __construct(string $reference, string $productReference, string $format, array $metadata)
    {
        $this->reference = $reference;
        $this->productReference = $productReference;
        $this->format = $format;
        $this->metadata = $metadata;
    }
}