<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

class User
{
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}