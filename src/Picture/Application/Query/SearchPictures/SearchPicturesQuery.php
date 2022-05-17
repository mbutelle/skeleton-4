<?php

declare(strict_types=1);

namespace App\Picture\Application\Query\SearchPictures;

use App\Shared\Application\Query\QueryInterface;

final class SearchPicturesQuery implements QueryInterface
{
    public ?int $offset = null;
    public ?int $limit = null;
    public ?int $createdAtSort = null;

    public function toCriteria(): array
    {
        $criteria = [];
        foreach (get_object_vars($this) as $property => $value) {
            if (null === $value) {
                continue;
            }

            $criteria[$property] = $value;
        }

        return $criteria;
    }
}