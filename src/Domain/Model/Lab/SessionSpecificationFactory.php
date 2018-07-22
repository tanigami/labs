<?php

namespace Shippinno\Labs\Domain\Model\Lab;

interface SessionSpecificationFactory
{
    /**
     * @param LabId $courseId
     * @return SessionBelongsToCourseSpecification
     */
    public function sessionBelongsToCourse(LabId $courseId): SessionBelongsToCourseSpecification;

    /**
     * @return SessionDisplayableSpecification
     */
    public function sessionDisplayable(): SessionDisplayableSpecification;
}