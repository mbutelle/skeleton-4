<?php

declare(strict_types=1);

namespace App\FileSystem\Application\Command\DeleteFile;

use App\Shared\Application\Command\CommandInterface;

final class DeleteFileCommand implements CommandInterface
{
    public string $reference;
}