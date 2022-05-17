<?php

declare(strict_types=1);

namespace App\Shared\Domain\Specification;

class NotSpecification implements SpecificationInterface
{
    private $specification;

    public function __construct(SpecificationInterface $specification)
    {
        $this->specification = $specification;
    }

    public function isSatisfiedBy($object): bool
    {
        return !$this->specification->isSatisfiedBy($object);
    }
}