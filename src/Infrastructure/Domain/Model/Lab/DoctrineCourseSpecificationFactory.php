<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\Lab;

use Shippinno\Labs\Domain\Model\Lab\CourseNameContainsSpecification;
use Shippinno\Labs\Domain\Model\Lab\CourseSpecificationFactory;

class DoctrineCourseSpecificationFactory implements CourseSpecificationFactory
{
    /**
     * @param string $string
     * @return DoctrineSessionBelongsToCourseSpecification
     */
    public function courseNameContains(string $string): CourseNameContainsSpecification
    {
        return new DoctrineCourseNameContainsSpecification($string);
    }
}