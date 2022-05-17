<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Dto\Input;

use App\Shared\Application\Query\QueryInterface;

interface InputQueryInterface
{
    public function getQuery(): QueryInterface;
}