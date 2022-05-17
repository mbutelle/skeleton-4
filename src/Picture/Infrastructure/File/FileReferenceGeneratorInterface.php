<?php

declare(strict_types=1);

namespace App\Picture\Infrastructure\File;

use Ramsey\Uuid\Uuid;

final class FileReferenceGeneratorInterface implements \App\Picture\Domain\File\FileReferenceGeneratorInterface
{
    public function generate(): string
    {
        return Uuid::uuid6()->toString();
    }
}