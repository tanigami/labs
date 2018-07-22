<?php

namespace Shippinno\Labs\Domain\Model\Lab;

interface CourseSpecificationFactory
{
    /**
     * @param string $string
     * @return CourseNameContainsSpecification
     */
    public function courseNameContains(string $string): CourseNameContainsSpecification;
}