<?php

namespace Shippinno\Labs\Domain\Model\Lab;

use Shippinno\Labs\Domain\Model\Common\Specification;

interface SessionRepository
{
    /**
     * @return Session[]
     */
    public function all(): array;

    /**
     * @param SessionId $sessionId
     * @return null|Session
     */
    public function sessionOfId(SessionId $sessionId): ?Session;

    /**
     * @param Specification $specification
     * @return Session[]
     */
    public function satisfying($specification): array;

    /**
     * @param LabId $courseId
     * @return Session[]
     */
    public function sessionsOfCourseId(LabId $courseId): array;

    /**
     * @param Session $session
     */
    public function add(Session $session): void;
}