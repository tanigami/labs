<?php

namespace Shippinno\Labs\Application\Service;

use DateTimeImmutable;
use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Domain\Model\Lab\LabRepository;
use Shippinno\Labs\Domain\Model\Lab\SessionId;
use Shippinno\Labs\Domain\Model\User\UserId;

class AttendSessionService
{
    /**
     * @var LabRepository
     */
    private $courseRepository;

    /**
     * @param LabRepository $courseRepository
     */
    public function __construct(LabRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * @param AttendSessionRequest $request
     */
    public function execute($request)
    {
        $course = $this->courseRepository->courseOfId(new LabId($request->courseId()));
        $course->addAttendanceToSession(
            new SessionId($request->sessionId()),
            new UserId($request->learnerId()),
            $this->now()
        );
    }

    protected function now(): DateTimeImmutable
    {
        return new DateTimeImmutable('now');
    }
}