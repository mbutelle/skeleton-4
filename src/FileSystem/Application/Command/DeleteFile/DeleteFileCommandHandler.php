<?php

declare(strict_types=1);

namespace App\FileSystem\Application\Command\DeleteFile;

use App\FileSystem\Domain\Model\FileRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final class DeleteFileCommandHandler implements CommandHandlerInterface
{
    private FileRepositoryInterface $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function __invoke(DeleteFileCommand $command): void
    {
        $this->fileRepository->delete($command->reference);
    }
}