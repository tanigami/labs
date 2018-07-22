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
     * @var Member[]
     */
    private $members;

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
        $this->members = new ArrayCollection;
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
     * @return Member[]
     */
    public function members(): Collection
    {
        return $this->members;
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
        return count($this->members) === $this->capacity();
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

    /**
     * @param UserId $userId
     * @param DateTimeImmutable $memberSince
     * @throws CourseFullException
     */
    public function addMember(User $user, DateTimeImmutable $memberSince): void
    {
        if ($this->isFull()) {
            throw new CourseFullException;
        }

        $this->members->add(new Member($user->userId(), $memberSince));
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isMember(User $user): bool
    {
        return $this->members()->exists(
            function (int $i, Member $member) use ($user) {
                return $member->learnerId()->equals($user->userId());
            }
        );
    }

    /**
     * @param User $user
     */
    public function removeMember(User $user): void
    {
        foreach ($this->members() as $i => $member) {
            if ($member->learnerId()->equals($user->userId())) {
                $this->members->removeElement($member);
            }
        }
    }





//    public function addAttendanceToSession(SessionId $sessionId, UserId $learnerId, DateTimeImmutable $now): void
//    {
//        if (!$this->isMember($learnerId)) {
//            // error
//        }
//
//        /** @var Session $session */
//        $session = $this->sessions()->filter(
//            function (Session $session) use ($sessionId) {
//                return $session->sessionId()->equals($sessionId);
//            }
//        )->last();
//
//        $session->addAttendance($learnerId, $now);
//    }
}
