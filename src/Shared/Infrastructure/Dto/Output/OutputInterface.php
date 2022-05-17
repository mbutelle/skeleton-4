<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Dto\Output;

interface OutputInterface
{
    public static function fromDomain($model): OutputInterface;
}