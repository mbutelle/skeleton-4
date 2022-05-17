<?php

declare(strict_types=1);

namespace App\Picture\Application\Query\SearchPictures;

use App\Picture\Domain\Model\PictureRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final class SearchPicturesQueryHandler implements QueryHandlerInterface
{
    private PictureRepositoryInterface $pictureRepository;

    public function __construct(PictureRepositoryInterface $pictureRepository)
    {
        $this->pictureRepository = $pictureRepository;
    }

    public function __invoke(SearchPicturesQuery $query): iterable
    {
        return $this->pictureRepository->search($query->toCriteria());
    }
}