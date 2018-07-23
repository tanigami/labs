<?php

namespace Shippinno\Labs\Application\Query\Lab;

use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\Expression;
use Shippinno\Labs\Application\Query\LabOrdering;
use Shippinno\Labs\Application\Query\Limiting;

class FilterLabs
{
    /**
     * @var Expression
     */
    private $expression;

    /**
     * @var null|LabOrdering
     */
    private $ordering;

    /**
     * @var null|Limiting
     */
    private $limiting;

    /**
     * @param Expression $expression
     * @param LabOrdering|null $ordering
     * @param Limiting|null $limiting
     */
    public function __construct(Expression $expression, LabOrdering $ordering = null, Limiting $limiting = null)
    {
        $this->expression = $expression;
        $this->ordering = $ordering;
        $this->limiting = $limiting;
    }

    /**
     * @return Expression
     */
    public function expression(): Expression
    {
        return $this->expression;
    }

    /**
     * @return null|LabOrdering
     */
    public function ordering(): ?LabOrdering
    {
        return $this->ordering;
    }

    /**
     * @return null|Limiting
     */
    public function limiting(): ?Limiting
    {
        return $this->limiting;
    }
}
