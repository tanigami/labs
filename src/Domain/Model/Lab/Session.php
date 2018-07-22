<?php

namespace Shippinno\Labs\Domain\Model\Lab;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Shippinno\Labs\Domain\Model\User\UserId;
use Tanigami\ValueObjects\Time\TimeRange;

class Session
{
    /**
     * @var SessionId
     */
    private $sessionId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var TimeRange
     */
    private $hours;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Attendance[]
     */
    private $attendances;

    /**
     * @param SessionId $sessionId
     * @param string $title
     * @param TimeRange $hours
     * @param string $description
     */
    public function __construct(
        SessionId $sessionId,
        string $title,
        TimeRange $hours,
        string $description
    ) {
        $this->sessionId = $sessionId;
        $this->title = $title;
        $this->hours = $hours;
        $this->description = $description;
        $this->attendances = new ArrayCollection;
    }

    /**
     * @return SessionId
     */
    public function sessionId(): SessionId
    {
        return $this->sessionId;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function changeTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return TimeRange
     */
    public function hours(): TimeRange
    {
        return $this->hours;
    }

    /**
     * @param TimeRange $hours
     */
    public function changeHours(TimeRange $hours): void
    {
        $this->hours = $hours;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * @param string $outline
     */
    public function changeOutline(string $outline): void
    {
        $this->description = $outline;
    }

    public function isOpen(): bool
    {
        $now = $this->now();

        return $this->hours()->start() <= $now && $now <= $this->hours()->end();
    }

    /**
     * @param UserId $learnerId
     * @param DateTimeImmutable $now
     */
    public function addAttendance(UserId $learnerId, DateTimeImmutable $now): void
    {
        $this->attendances->add(new Attendance($learnerId, $now));
    }

    /**
     * @return DateTimeImmutable
     */
    protected function now(): DateTimeImmutable
    {
        return new DateTimeImmutable;
    }
}
