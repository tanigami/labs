<?php

namespace Shippinno\Labs\Domain\Model\Lab;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Shippinno\Labs\Domain\Model\User\User;
use Shippinno\Labs\Domain\Model\User\UserId;
use Tanigami\ValueObjects\Time\TimeRange;
use Tanigami\ValueObjects\Web\Url;

class Lab
{
    /**
     * @var LabId
     */
    private $labId;

    /**
     * @var UserId
     */
    private $ownerId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $overview;

    /**
     * @var int
     */
    private $capacity;

    /**
     * @var null|Url
     */
    private $image;

    /**
     * @var Enrollment[]
     */
    private $enrollments;

    /**
     * @var Session[]
     */
    private $sessions;

    /**
     * @param LabId $labId
     * @param UserId $ownerId
     * @param string $name
     * @param string $subject
     * @param string $overview
     * @param int $capacity
     * @param Url|null $image
     */
    public function __construct(
        LabId $labId,
        UserId $ownerId,
        string $name,
        string $subject,
        string $overview,
        int $capacity,
        Url $image = null
    ) {
        $this->labId = $labId;
        $this->ownerId = $ownerId;
        $this->name = $name;
        $this->subject = $subject;
        $this->overview = $overview;
        $this->capacity = $capacity;
        $this->image = $image;
        $this->enrollments = new ArrayCollection;
        $this->sessions = new ArrayCollection;
    }

    /**
     * @return LabId
     */
    public function labId(): LabId
    {
        return $this->labId;
    }

    /**
     * @return UserId
     */
    public function ownerId(): UserId
    {
        return $this->ownerId;
    }


    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function changeName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function subject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function changeSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function overview(): string
    {
        return $this->overview;
    }

    /**
     * @param string $overview
     */
    public function changeOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    /**
     * @return int
     */
    public function capacity(): int
    {
        return $this->capacity;
    }

    /**
     * @param string $capacity
     */
    public function changeCapacity(string $capacity): void
    {
        $this->capacity = $capacity;
    }

    /**
     * @return null|Url
     */
    public function image(): ?Url
    {
        return $this->image;
    }

    /**
     * @param Url|null $image
     */
    public function changeImage(Url $image = null): void
    {
        $this->image = $image;
    }

    /**
     * @return Enrollment[]
     */
    public function enrollments(): Collection
    {
        return $this->enrollments;
    }

    /**
     * @return Session[]
     */
    public function sessions(): Collection
    {
        return $this->sessions;
    }

    /**
     * @return bool
     */
    public function isFull(): bool
    {
        return count($this->enrollments) === $this->capacity();
    }

    /**
     * @param SessionId $sessionId
     * @param string $title
     * @param TimeRange $hours
     * @param string $description
     */
    public function addSession(SessionId $sessionId, string $title, TimeRange $hours, string $description): void
    {
        $session = new Session(
            $sessionId,
            $title,
            $hours,
            $description
        );
        $this->sessions->add($session);
    }

    /**
     * @param SessionId $sessionId
     * @return null|Session
     */
    public function sessionOfId(SessionId $sessionId): ?Session
    {
        foreach ($this->sessions() as $session) {
            if ($session->sessionId()->equals($sessionId)) {
                return $session;
            }
        }

        return null;
    }

    /**
     * @param SessionId $sessionId
     * @param string $title
     * @param TimeRange $hours
     * @param string $outline
     * @throws SessionNotFoundException
     */
    public function updateSession(SessionId $sessionId, string $title, TimeRange $hours, string $outline): void
    {
        $session = $this->sessionOfId($sessionId);
        if (is_null($sessionId)) {
            throw new SessionNotFoundException;
        }
        $session->changeTitle($title);
        $session->changeHours($hours);
        $session->changeOutline($outline);
    }

    /**
     * @param SessionId $sessionId
     * @throws SessionNotFoundException
     */
    public function removeSession(SessionId $sessionId): void
    {
        foreach ($this->sessions() as $session) {
            if ($session->sessionId()->equals($sessionId)) {
                $this->sessions->removeElement($session);

                return;
            }
        }
        throw new SessionNotFoundException;
    }

    public function addAttendanceToSession(SessionId $sessionId, UserId $learnerId, DateTimeImmutable $now): void
    {
        if (!$this->enrolledLearner($learnerId)) {
            // error
        }

        /** @var Session $session */
        $session = $this->sessions()->filter(
            function (Session $session) use ($sessionId) {
                return $session->sessionId()->equals($sessionId);
            }
        )->last();

        $session->addAttendance($learnerId, $now);
    }

    public function enrolledLearner(UserId $learnerId): bool
    {
        return $this->enrollments()->exists(function (int $i, Enrollment $enrollment) use ($learnerId) {
            return $enrollment->learnerId()->equals($learnerId);
        });
    }

    /**
     * @param UserId $learnerId
     * @param DateTimeImmutable $now
     * @throws CourseAlreadyFullException
     */
    public function addEnrollment(UserId $learnerId, DateTimeImmutable $now): void
    {
        if ($this->isFull()) {
            throw new CourseAlreadyFullException;
        }

        $this->enrollments->add(new Enrollment($learnerId, $now));
    }

    /**
     * @param User $learner
     */
    public function cancel(Enrollment $enrollment)
    {
        foreach ($this->enrollments() as $i => $enrollment) {
            if ($enrollment->learnerId()->equals($learner->userId())) {
                unset($this->enrollments[$i]);
            }
        }
    }
}
