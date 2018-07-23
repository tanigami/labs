<?php

namespace Shippinno\Labs\Domain\Model\Common;

class NotSpecification extends Specification
{
    /**
     * @var Specification
     */
    private $specification;

    /**
     * @param Specification $specification
     */
    public function __construct(Specification $specification)
    {
        parent::__construct();
        $this->specification = $specification;
    }

    /**
     * @inheritdoc
     */
    public function isSatisfiedBy($entity): bool
    {
        return !$this->specification->isSatisfiedBy($entity);
    }
}
