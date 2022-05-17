<?php

declare(strict_types=1);

namespace App\FileSystem\Infrastructure\Subscriber;

use App\FileSystem\Application\Command\SaveFile\SaveFileCommand;
use App\Shared\Infrastructure\Bus\Command\CommandBus;
use App\Shared\Infrastructure\Message\File\SaveFile;
use App\Shared\Infrastructure\Message\MessageHandlerInterface;

final class SaveFileHandler implements MessageHandlerInterface
{
    private CommandBus $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(SaveFile $event): void
    {
        $command = new SaveFileCommand(
            $event->reference,
            $event->filename,
            $event->mimeType,
            $event->content
        );

        $this->bus->handle($command);
    }
}