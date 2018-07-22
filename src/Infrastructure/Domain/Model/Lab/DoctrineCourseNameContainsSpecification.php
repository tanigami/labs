<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\Lab;

use Happyr\DoctrineSpecification\Spec;
use Shippinno\Labs\Domain\Model\Lab\CourseNameContainsSpecification;

class DoctrineCourseNameContainsSpecification extends CourseNameContainsSpecification
{
    /**
     * {@inheritdoc}
     */
    protected function getSpec()
    {
        return Spec::like('name', $this->string);
    }
}