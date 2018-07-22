<?php

namespace Shippinno\Labs\Domain\Model\Lab;

abstract class SessionBelongsToCourseSpecification extends SessionSpecification
{
    /**
     * @var LabId
     */
    protected $courseId;

    /**
     * @param LabId $courseId
     */
    public function __construct(LabId $courseId)
    {
        parent::__construct();
        $this->courseId = $courseId;
    }

    /**
     * @param Session $session
     * @return bool
     */
    public function isSatisfiedBy($session): bool
    {
        return $session->courseId()->equals($this->courseId);
    }
}