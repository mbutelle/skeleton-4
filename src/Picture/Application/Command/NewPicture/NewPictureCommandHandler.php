<?php

declare(strict_types=1);

namespace App\Picture\Application\Command\NewPicture;

use App\Picture\Domain\Model\Picture;
use App\Picture\Domain\Model\PictureRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final class NewPictureCommandHandler implements CommandHandlerInterface
{
    private PictureRepositoryInterface $pictureRepository;

    public function __construct(PictureRepositoryInterface $pictureRepository)
    {
        $this->pictureRepository = $pictureRepository;
    }

    public function __invoke(NewPictureCommand $command): void
    {
        $picture = new Picture(
            $command->reference,
            $command->fileReference,
            $command->author,
            $command->description,
        );

        $this->pictureRepository->save($picture);
    }
}