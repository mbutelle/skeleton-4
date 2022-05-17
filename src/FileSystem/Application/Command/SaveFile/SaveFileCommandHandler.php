<?php

declare(strict_types=1);

namespace App\FileSystem\Application\Command\SaveFile;

use App\FileSystem\Domain\Model\FileRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final class SaveFileCommandHandler implements CommandHandlerInterface
{
    private FileRepositoryInterface $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function __invoke(SaveFileCommand $command): void
    {
        $this->fileRepository->save($command->toModel());
    }
}