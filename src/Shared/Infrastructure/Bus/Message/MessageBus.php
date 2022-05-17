<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Message;

use App\Shared\Application\Exception\CommandException;
use App\Shared\Infrastructure\Message\MessageInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessageBus
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function dispatch(MessageInterface $message): void
    {
        try {
            $this->messageBus->dispatch($message);
        } catch (\Exception $e) {
            throw new CommandException($e->getMessage(), $e->getCode(), $e);
        }
    }
}