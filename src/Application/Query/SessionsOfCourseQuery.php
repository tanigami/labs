<?php

namespace Shippinno\Labs\Application\Query;

class SessionsOfCourseQuery implements Query
{
    /**
     * @var string
     */
    private $courseId;

    /**
     * @var null|SessionOrdering
     */
    private $ordering;

    /**
     * @var null|Limiting
     */
    private $limiting;

    /**
     * @param string $courseId
     * @param SessionOrdering|null $ordering
     * @param Limiting|null $limiting
     */
    public function __construct(string $courseId, SessionOrdering $ordering = null, Limiting $limiting = null)
    {
        $this->courseId = $courseId;
        $this->limiting = $limiting;
        $this->ordering = $ordering;
    }

    /**
     * @return string
     */
    public function courseId(): string
    {
        return $this->courseId;
    }

    /**
     * @return null|SessionOrdering
     */
    public function ordering(): ?SessionOrdering
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
