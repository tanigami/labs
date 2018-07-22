<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\Lab;

use Happyr\DoctrineSpecification\Spec;
use Shippinno\Labs\Domain\Model\Lab\SessionBelongsToCourseSpecification;
use Shippinno\Labs\Domain\Model\Lab\SessionOrdering;

class DoctrineSessionBelongsToCourseSpecification extends SessionBelongsToCourseSpecification
{
    /**
     * {@inheritdoc}
     */
    protected function getSpec()
    {
        return Spec::eq('courseId', $this->courseId);
    }
}
