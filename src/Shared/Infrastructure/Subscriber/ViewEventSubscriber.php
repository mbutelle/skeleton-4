<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Subscriber;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ViewEventSubscriber implements EventSubscriberInterface
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => 'onView',
        ];
    }

    public function onView(ViewEvent $event): void
    {
        $result = $event->getControllerResult();

        if ($result instanceof Response) {
            return;
        }

        if (null === $result) {
            $event->setResponse(new JsonResponse(null, Response::HTTP_NO_CONTENT));

            return;
        }

        $context = (new SerializationContext())
            ->setSerializeNull(false)
        ;

        $event->setResponse(JsonResponse::fromJsonString(
            $this->serializer->serialize($result, 'json', $context)
        ));
    }
}