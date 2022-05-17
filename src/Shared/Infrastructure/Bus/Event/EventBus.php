<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event;

use App\Shared\Application\Event\EventDispatcherInterface;
use App\Shared\Application\Event\EventInterface;
use App\Shared\Application\Exception\CommandException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

final class EventBus implements EventDispatcherInterface
{
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function dispatch(EventInterface $event): void
    {
        try {
            $this->eventBus->dispatch(
                (new Envelope($event))
                    ->with(new DispatchAfterCurrentBusStamp())
            );
        } catch (\Exception $e) {
            throw new CommandException($e->getMessage(), $e->getCode(), $e);
        }
    }
}