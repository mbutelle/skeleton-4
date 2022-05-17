<?php

declare(strict_types=1);

namespace App\FileSystem\Infrastructure\Controller;

use App\FileSystem\Application\Command\DeleteFile\DeleteFileCommand;
use App\Shared\Infrastructure\Bus\Command\CommandBus;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("{reference}", methods={"DELETE"})
 */
final class DeleteFileAction
{
    private CommandBus $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(string $reference): void
    {
        $this->bus->handle(
            new DeleteFileCommand($reference)
        );
    }
}