<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Command;

use App\Shared\Application\Command\CommandInterface;
use App\Shared\Application\Exception\CommandException;
use Symfony\Component\Messenger\MessageBusInterface;

final class CommandBus
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function handle(CommandInterface $command): void
    {
        try {
            $this->messageBus->dispatch($command);
        } catch (\Exception $e) {
            throw new CommandException($e->getMessage(), $e->getCode(), $e);
        }
    }
}