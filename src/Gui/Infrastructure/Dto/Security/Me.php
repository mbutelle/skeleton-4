<?php

declare(strict_types=1);

namespace App\Gui\Infrastructure\Dto\Security;

use App\Security\Model\User;

final class Me
{
    public int $id;
    public string $username;
    public string $name;
    public array $roles;

    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->username = $user->username;
        $this->name = $user->name;
        $this->roles = $user->roles;
    }
}