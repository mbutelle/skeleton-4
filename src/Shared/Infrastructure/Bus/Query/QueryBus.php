<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Query;

use App\Shared\Application\Query\QueryInterface;
use App\Shared\Application\Exception\CommandException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class QueryBus
{
    private MessageBusInterface $queryBus;

    private $lastResult;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function handle(QueryInterface $query): void
    {
        try {
            $this->lastResult = $this->queryBus->dispatch($query);
        } catch (\Exception $e) {
            throw new CommandException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getLastResult()
    {
        return $this->lastResult->last(HandledStamp::class)->getResult();
    }
}