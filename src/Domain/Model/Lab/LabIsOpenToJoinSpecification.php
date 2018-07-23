<?php

namespace Shippinno\Labs\Domain\Model\Lab;

use Shippinno\Labs\Domain\Model\Common\Specification;

class LabIsOpenToJoinSpecification extends Specification
{
    /**
     * @param Lab $entity
     * @return bool
     */
    public function isSatisfiedBy($lab): bool
    {
        return $lab->isOpenToJoin();
    }
}