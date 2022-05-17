<?php

declare(strict_types=1);

namespace App\FileSystem\Application\Command\SaveFiles;

use App\FileSystem\Domain\Model\FileRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final class SaveFilesCommandHandler implements CommandHandlerInterface
{
    private FileRepositoryInterface $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function __invoke(SaveFilesCommand $command): void
    {
        foreach ($command->commands as $subCommand) {
            $this->fileRepository->save($subCommand->toModel());
        }
    }
}