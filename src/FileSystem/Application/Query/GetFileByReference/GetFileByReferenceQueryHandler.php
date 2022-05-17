<?php

declare(strict_types=1);

namespace App\FileSystem\Application\Query\GetFileByReference;

use App\FileSystem\Domain\Model\File;
use App\FileSystem\Domain\Model\FileRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final class GetFileByReferenceQueryHandler implements QueryHandlerInterface
{
    private FileRepositoryInterface $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function __invoke(GetFileByReferenceQuery $query): ?File
    {
        return $this->fileRepository->get($query->reference);
    }
}