<?php

namespace Shippinno\Labs\Application\Service;

class EnrollInCourseRequest
{
    /**
     * @var string
     */
    private $courseId;

    /**
     * @var string
     */
    private $learnerId;

    /**
     * @param string $courseId
     * @param string $learnerId
     */
    public function __construct(string $courseId, string $learnerId)
    {
        $this->courseId = $courseId;
        $this->learnerId = $learnerId;
    }

    /**
     * @return string
     */
    public function courseId(): string
    {
        return $this->courseId;
    }

    /**
     * @return string
     */
    public function learnerId(): string
    {
        return $this->learnerId;
    }
}
