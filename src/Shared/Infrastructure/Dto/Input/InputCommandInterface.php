<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Dto\Input;

use App\Shared\Application\Command\CommandInterface;

interface InputCommandInterface
{
    public function getCommand(): CommandInterface;
}