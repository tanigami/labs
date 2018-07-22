<?php

namespace Shippinno\Labs\Infrastructure\Persistence\Doctrine\Specification;

use BadMethodCallException;
use Happyr\DoctrineSpecification\Spec;
use Shippinno\Labs\Domain\Model\Common\Specification;

class LimitSpecification extends Specification
{
    /**
     * @var int
     */
    private $limit;

    /**
     * @param int $limit
     */
    public function __construct(int $limit)
    {
        parent::__construct();
        $this->limit = $limit;
    }

    /**
     * @param mixed $entity
     * @return bool
     */
    public function isSatisfiedBy($entity): bool
    {
        throw new BadMethodCallException;
    }

    /**
     * {@inheritdoc}
     */
    protected function getSpec()
    {
        return Spec::limit($this->limit);
    }
}