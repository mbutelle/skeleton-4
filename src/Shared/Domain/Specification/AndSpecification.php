<?php

declare(strict_types=1);

namespace App\Shared\Domain\Specification;

final class AndSpecification implements SpecificationInterface
{
    /**
     * @var SpecificationInterface[]
     */
    private $specifications = [];

    public function __construct(array $specifications)
    {
        $this->specifications = $specifications;
    }

    public function isSatisfiedBy($object): bool
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($object)) {
                return false;
            }
        }

        return true;
    }
}