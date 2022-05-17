<?php

declare(strict_types=1);

namespace App\FileSystem\Application\Query\GetFileByReference;

use App\Shared\Application\Query\QueryInterface;

final class GetFileByReferenceQuery implements QueryInterface
{
    public string $reference;

    public function __construct(string $reference)
    {
        $this->reference = $reference;
    }
}