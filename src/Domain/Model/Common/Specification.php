<?php

namespace Shippinno\Labs\Domain\Model\Common;

use Happyr\DoctrineSpecification\BaseSpecification;

abstract class Specification extends BaseSpecification
{
    /**
     * @param Specification $other
     * @return AndSpecification
     */
    public function and(Specification $other): AndSpecification
    {
        return new AndSpecification($this, $other);
    }

    /**
     * @param mixed $entity
     * @return bool
     */
    abstract public function isSatisfiedBy($entity): bool;
}