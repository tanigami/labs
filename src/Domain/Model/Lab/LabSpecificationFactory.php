<?php

namespace Shippinno\Labs\Domain\Model\Lab;

class LabSpecificationFactory
{
    /**
     * @param string $string
     * @return LabNameContainsSpecification
     */
    public function nameContains(string $string): LabNameContainsSpecification
    {
        return new LabNameContainsSpecification($string);
    }

    /**
     * @return LabIsOpenToJoinSpecification
     */
    public function openToJoin(): LabIsOpenToJoinSpecification
    {
        return new LabIsOpenToJoinSpecification;
    }
}