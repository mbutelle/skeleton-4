<?php

declare(strict_types=1);

namespace App\Security\Model;

use App\Shared\Domain\Model\User as DomainUser;

class User extends DomainUser
{
    public string $username;
    public string $password;
    public array $roles = [];

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getRoles()
    {
        return array_merge($this->roles, [
           'ROLE_USER',
        ]);
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }
}