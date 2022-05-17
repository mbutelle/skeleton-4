<?php

declare(strict_types=1);

namespace App\Picture\Domain\Model;

final class Picture
{
    public string $reference;

    public string $fileReference;

    public string $author;
    public ?string $description = null;

    public \DateTime $createdAt;

    public function __construct(string $reference, string $fileReference, string $author, ?string $description = null)
    {
        $this->reference = $reference;
        $this->fileReference = $fileReference;
        $this->author = $author;
        $this->description = $description;

        $this->createdAt = new \DateTime();
    }
}