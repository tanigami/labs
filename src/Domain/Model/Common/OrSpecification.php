<?php

namespace Shippinno\Labs\Domain\Model\Common;

use Happyr\DoctrineSpecification\Spec;

class OrSpecification extends Specification
{
    /**
     * @var Specification
     */
    private $one;

    /**
     * @var Specification
     */
    private $other;

    /**
     * @param Specification $one
     * @param Specification $other
     */
    public function __construct(Specification $one, Specification $other)
    {
        parent::__construct();
        $this->one = $one;
        $this->other = $other;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy($entity): bool
    {
        return $this->one->isSatisfiedBy($entity) || $this->other->isSatisfiedBy($entity);
    }

    protected function getSpec()
    {
        return Spec::orX($this->one, $this->other);
    }
}