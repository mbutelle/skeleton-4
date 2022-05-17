<?php

declare(strict_types=1);

namespace App\Picture\Application\Command\NewPicture;

use App\Shared\Application\Command\CommandInterface;

final class NewPictureCommand implements CommandInterface
{
    public string $reference;
    public string $fileReference;
    public string $author;
    public ?string $description = null;

    public function __construct(string $reference, string $fileReference, string $author, ?string $description = null)
    {
        $this->reference = $reference;
        $this->fileReference = $fileReference;
        $this->author = $author;
        $this->description = $description;
    }
}