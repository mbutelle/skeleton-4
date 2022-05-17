<?php

declare(strict_types=1);

namespace App\FileSystem\Application\Command\SaveFiles;

use App\FileSystem\Application\Command\SaveFile\SaveFileCommand;
use App\Shared\Application\Command\CommandInterface;

final class SaveFilesCommand implements CommandInterface
{
    /** @var SaveFileCommand[] */
    public array $commands = [];

    public function __construct(array $commands)
    {
        $this->commands = $commands;
    }
}