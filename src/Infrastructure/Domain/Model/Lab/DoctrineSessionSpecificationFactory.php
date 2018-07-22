<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\Lab;

use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Domain\Model\Lab\SessionBelongsToCourseSpecification;
use Shippinno\Labs\Domain\Model\Lab\SessionDisplayableSpecification;
use Shippinno\Labs\Domain\Model\Lab\SessionSpecificationFactory;

class DoctrineSessionSpecificationFactory implements SessionSpecificationFactory
{
    /**
     * {@inheritdoc}
     * @return DoctrineSessionBelongsToCourseSpecification
     */
    public function sessionBelongsToCourse(LabId $courseId): SessionBelongsToCourseSpecification
    {
        return new DoctrineSessionBelongsToCourseSpecification($courseId);
    }

    /**
     * @return DoctrineSessionDisplayableSpecification
     */
    public function sessionDisplayable(): SessionDisplayableSpecification
    {
        return new DoctrineSessionDisplayableSpecification;
    }
}
