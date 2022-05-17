<?php

declare(strict_types=1);

namespace App\FileSystem\Infrastructure\Controller;

use App\FileSystem\Application\Query\GetFileByReference\GetFileByReferenceQuery;
use App\FileSystem\Domain\Model\File;
use App\Shared\Infrastructure\Bus\Query\QueryBus;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{reference}", methods={"GET"})
 */
final class GetFileAction
{
    private QueryBus $bus;
    private SerializerInterface $serializer;

    public function __construct(QueryBus $bus, SerializerInterface $serializer)
    {
        $this->bus = $bus;
        $this->serializer = $serializer;
    }

    public function __invoke(string $reference): Response
    {
        $query = new GetFileByReferenceQuery($reference);

        $this->bus->handle($query);

        $file = $this->bus->getLastResult();

        $context = (new SerializationContext())
            ->setSerializeNull(false)
        ;

        $response = JsonResponse::fromJsonString(
            $this->serializer->serialize($file, 'json', $context)
        );

        $response
            ->setPublic()
            ->setMaxAge(3600*24)
        ;

        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }
}