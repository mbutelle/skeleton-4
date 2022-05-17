<?php

declare(strict_types=1);

namespace App\Picture\Infrastructure\Repository;

use App\Picture\Domain\Model\Picture;
use App\Picture\Domain\Model\PictureRepositoryInterface;
use App\Shared\Infrastructure\Mongo\MongoFilter;
use MongoDB\Collection;

final class MongoPictureRepository implements PictureRepositoryInterface
{
    private Collection $collection;

    public function __construct(Collection $pictureCollection)
    {
        $this->collection = $pictureCollection;
    }

    public function get(string $reference): ?Picture
    {
        $picture = $this->collection->findOne(['reference' => $reference], MongoFilter::FIND_OPTIONS);

        if (null === $picture) {
            return null;
        }

        $picture = new Picture(
            $picture['reference'],
            $picture['fileReference'],
            $picture['author'],
            $picture['description'],
        );

        $picture->createdAt = new \DateTime($picture['created_at']['date']);

        return $picture;
    }

    public function search(array $criteria): iterable
    {
        $filter = new MongoFilter();
        $options = [];

        if (isset($criteria['limit'])) {
            $options['limit'] = $criteria['limit'];
        }

        if (isset($criteria['offset'])) {
            $options['skip'] = $criteria['offset'];
        }

        if (isset($criteria['createdAtSort'])) {
            $options['sort'] = ['createdAt.date' => $criteria['createdAtSort']];
        }

        $pictures = $this->collection->find($this->encode($filter->getFilters()), array_merge(MongoFilter::FIND_OPTIONS, $options));

        foreach ($pictures as $picture) {
            $pic = new Picture(
                $picture['reference'],
                $picture['fileReference'],
                $picture['author'],
                $picture['description'],
            );

            $pic->createdAt = new \DateTime($picture['createdAt']['date']);

            yield $pic;
        }
    }

    public function save(Picture $picture): void
    {
        $this->collection->insertOne($this->encode($picture));
    }

    private function encode($value)
    {
        return json_decode(json_encode($value), true);
    }
}