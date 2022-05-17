<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Subscriber;

use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;

final class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        SerializerInterface $serializer,
        RouterInterface $router,
        LoggerInterface $logger
    ) {
        $this->serializer = $serializer;
        $this->router = $router;
        $this->logger = $logger;
    }

    public function processException(ExceptionEvent $event)
    {
        if (!preg_match('/\/api\//', $this->router->getContext()->getPathInfo())) {
            return;
        }

        $code = in_array($event->getThrowable()->getCode(), array_keys(Response::$statusTexts)) ? $event->getThrowable()->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        $body = $this->serializer->serialize([
            'code' => $code,
            'message' => $event->getThrowable()->getMessage(),
            'error_source' => $this->getErrorSource($event->getThrowable())->getMessage(),
            'date' => new \DateTime(),
        ], 'json');

        $event->setResponse(JsonResponse::fromJsonString($body, $code));

        $this->logger->error(sprintf(
            'Exception: %s. File: %s:%d',
            $event->getThrowable()->getMessage(),
            $event->getThrowable()->getFile(),
            $event->getThrowable()->getLine()
        ));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [['processException', 255]],
        ];
    }

    private function getErrorSource(\Throwable $throwable): \Throwable
    {
        if (null === $throwable->getPrevious()) {
            return $throwable;
        }

        return $this->getErrorSource($throwable->getPrevious());
    }
}
