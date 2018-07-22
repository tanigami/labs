<?php

namespace Shippinno\Labs\Application\Service;

use DateTimeImmutable;
use Shippinno\Labs\Domain\Model\Lab\CourseFullException;
use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Domain\Model\Lab\LabRepository;
use Shippinno\Labs\Domain\Model\Lab\EnrollmentRepository;
use Shippinno\Labs\Domain\Model\User\UserId;
use Shippinno\Labs\Domain\Model\User\UserRepository;

class EnrollInCourseService
{
    /**
     * @var LabRepository
     */
    private $courseRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param LabRepository $courseRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        LabRepository $courseRepository,
        UserRepository $userRepository
    ) {
        $this->courseRepository = $courseRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param EnrollInCourseRequest $request
     */
    public function execute($request)
    {
        $course = $this->courseRepository->courseOfId(new LabId($request->courseId()));
        $learner = $this->userRepository->userOfId(new UserId($request->learnerId()));
        $course->addEnrollment($learner->userId(), $this->now());
    }

    protected function now(): DateTimeImmutable
    {
        return new DateTimeImmutable('now');
    }
}