<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Message\File;

use App\Shared\Infrastructure\Message\MessageInterface;

final class SaveFile implements MessageInterface
{
    public string $reference;
    public string $filename;
    public string $mimeType;
    public string $content;

    public function __construct(string $reference, string $filename, string $mimeType, string $content)
    {
        $this->reference = $reference;
        $this->filename = $filename;
        $this->mimeType = $mimeType;
        $this->content = $content;
    }
}