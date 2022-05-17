<?php

declare(strict_types=1);

namespace App\Picture\Domain\File;

interface FileReferenceGeneratorInterface
{
    public function generate(): string;
}