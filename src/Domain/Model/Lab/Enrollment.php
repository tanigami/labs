<?php

namespace Shippinno\Labs\Domain\Model\Lab;

use DateTimeImmutable;
use Shippinno\Labs\Domain\Model\User\UserId;

class Enrollment
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
    private $enrolledAt;

    /**
     * @param UserId $learnerId
     * @param DateTimeImmutable $enrolledAt
     */
    public function __construct(UserId $learnerId, DateTimeImmutable $enrolledAt)
    {
        $this->learnerId = $learnerId;
        $this->enrolledAt = $enrolledAt;
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
    public function enrolledAt(): DateTimeImmutable
    {
        return $this->enrolledAt;
    }
}
