<?php

namespace Shippinno\Labs\Domain\Model\Lab;

use DateTimeImmutable;
use Shippinno\Labs\Domain\Model\User\UserId;

class Attendance
{
    /**
     * @var int
     */
    private $surrogateId;

    /**
     * @var UserId
     */
    private $learnerId;

    /**
     * @var DateTimeImmutable
     */
    private $attendedAt;

    /**
     * @param UserId $learnerId
     * @param DateTimeImmutable $attendedAt
     */
    public function __construct(UserId $learnerId, DateTimeImmutable $attendedAt)
    {
        $this->learnerId = $learnerId;
        $this->attendedAt = $attendedAt;
    }

    /**
     * @return UserId
     */
    public function learnerId(): UserId
    {
        return $this->learnerId;
    }

    /**
     * @return DateTimeImmutable
     */
    public function attendedAt(): DateTimeImmutable
    {
        return $this->attendedAt;
    }
}