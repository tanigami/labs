<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\Lab;

use Happyr\DoctrineSpecification\Spec;
use Shippinno\Labs\Domain\Model\Lab\LabNameContainsSpecification;

class DoctrineLabNameContainsSpecification extends LabNameContainsSpecification
{
    /**
     * {@inheritdoc}
     */
    protected function getSpec()
    {
        return Spec::like('name', $this->string);
    }
}