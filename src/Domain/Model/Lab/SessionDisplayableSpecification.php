<?php

namespace Shippinno\Labs\Domain\Model\Lab;

use Shippinno\Labs\Domain\Model\Common\Specification;

class SessionDisplayableSpecification extends Specification
{
    /**
     * @param mixed $entity
     * @return bool
     */
    public function isSatisfiedBy($entity): bool
    {
        return true;
    }


}