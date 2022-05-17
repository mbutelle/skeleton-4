<?php

declare(strict_types=1);

namespace App\Picture\Infrastructure\Controller;

use App\Picture\Application\Query\SearchPictures\SearchPicturesQuery;
use App\Shared\Infrastructure\Bus\Query\QueryBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

#[Route('', name: 'search_pictures', methods: ['GET'])]
final class SearchPicturesAction
{
    private QueryBus $bus;

    public function __construct(QueryBus $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): array
    {
        $query = new SearchPicturesQuery();
        foreach (get_class_vars(SearchPicturesQuery::class) as $property => $value) {
            $query->$property = (int) $request->get(u($property)->snake()->toString());
        }

        $this->bus->handle($query);

        return \iterator_to_array($this->bus->getLastResult());
    }
}