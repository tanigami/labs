<?php

namespace Shippinno\Labs\Infrastructure\Persistence\Doctrine\Specification;

use BadMethodCallException;
use Happyr\DoctrineSpecification\Spec;
use Shippinno\Labs\Domain\Model\Common\Specification;

class OrderBySpecification extends Specification
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $order;

    /**
     * @param string $field
     * @param string $order
     */
    public function __construct(string $field, string $order)
    {
        parent::__construct();
        $this->field = $field;
        $this->order = $order;
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
        return Spec::orderBy($this->field, $this->order);
    }
}