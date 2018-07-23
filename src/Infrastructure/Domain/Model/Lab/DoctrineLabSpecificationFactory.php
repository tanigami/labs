<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\Lab;

use Shippinno\Labs\Domain\Model\Lab\LabIsOpenToJoinSpecification;
use Shippinno\Labs\Domain\Model\Lab\LabNameContainsSpecification;
use Shippinno\Labs\Domain\Model\Lab\LabSpecificationFactory;

class DoctrineLabSpecificationFactory extends LabSpecificationFactory
{
    /**
     * @param string $string
     * @return LabNameContainsSpecification
     */
    public function nameContains(string $string): LabNameContainsSpecification
    {
        return new DoctrineLabNameContainsSpecification($string);
    }

    /**
     * @return LabIsOpenToJoinSpecification
     */
    public function openToJoin(): LabIsOpenToJoinSpecification
    {
        return new DoctrineLabIsOpenToJoinSpecification();
    }
}