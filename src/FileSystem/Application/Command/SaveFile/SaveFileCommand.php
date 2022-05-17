<?php

declare(strict_types=1);

namespace App\FileSystem\Application\Command\SaveFile;

use App\FileSystem\Domain\Model\File;
use App\Shared\Application\Command\CommandInterface;

final class SaveFileCommand implements CommandInterface
{
    public string $reference;
    public string $filename;
    public ?string $mimeType = null;
    public string $content;

    public function __construct(string $reference, string $filename, ?string $mimeType, string $content)
    {
        $this->reference = $reference;
        $this->filename = $filename;
        $this->mimeType = $mimeType;
        $this->content = $content;
    }

    public function toModel(): File
    {
        return new File(
            $this->reference,
            $this->filename,
            $this->mimeType,
            $this->content
        );
    }
}