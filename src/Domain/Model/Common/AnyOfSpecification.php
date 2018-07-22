<?php

namespace Shippinno\Labs\Domain\Model\Common;

use Happyr\DoctrineSpecification\Spec;

class AnyOfSpecification extends Specification
{
    /**
     * @var Specification[]
     */
    private $specifications;

    /**
     * @param Specification[] ...$specifications
     */
    public function __construct(Specification ...$specifications)
    {
        parent::__construct();
        $this->specifications = $specifications;
    }
    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy($object): bool
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($object)) {
                return false;
            }
        }
        return true;
    }

    protected function getSpec()
    {
        $spec = new Spec;
        foreach ($this->specifications as $specification) {
            $spec = Spec::andX($spec, $specification);
        }

        return $spec;
    }
}