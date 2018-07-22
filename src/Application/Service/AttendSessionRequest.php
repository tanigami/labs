<?php

namespace Shippinno\Labs\Application\Service;

class AttendSessionRequest
{
    /**
     * @var string
     */
    private $courseId;

    /**
     * @var string
     */
    private $sessionId;

    /**
     * @var string
     */
    private $learnerId;

    /**
     * @param string $sessionId
     * @param string $learnerId
     */
    public function __construct(string $courseId, string $sessionId, string $learnerId)
    {
        $this->courseId = $courseId;
        $this->sessionId = $sessionId;
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
    public function sessionId(): string
    {
        return $this->sessionId;
    }

    /**
     * @return string
     */
    public function learnerId(): string
    {
        return $this->learnerId;
    }
}
