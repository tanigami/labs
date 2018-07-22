<?php

namespace Shippinno\Labs\Application\Query;

use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\Expression;

class AllCoursesQuery implements Query
{
    /**
     * @var Comparison[]
     */
    private $comparisons;

    /**
     * @var CourseOrdering
     */
    private $ordering;

    /**
     * @var Limiting
     */
    private $limiting;

    /**
     * @param Comparison[] $comparisons
     */
    public function __construct(array $comparisons, CourseOrdering $ordering, Limiting $limiting)
    {
        $this->comparisons = $comparisons;
        $this->ordering = $ordering;
        $this->limiting = $limiting;
    }

    /**
     * @return Comparison[]
     */
    public function comparisons(): array
    {
        return $this->comparisons;
    }

    /**
     * @return Comparison[]
     */
    public function getComparisons(): array
    {
        return $this->comparisons;
    }

    /**
     * @return CourseOrdering
     */
    public function ordering(): CourseOrdering
    {
        return $this->ordering;
    }

    /**
     * @return Limiting
     */
    public function limiting(): Limiting
    {
        return $this->limiting;
    }
}
