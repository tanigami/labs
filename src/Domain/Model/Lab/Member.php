<?php

namespace Shippinno\Labs\Domain\Model\Lab;

use DateTimeImmutable;
use Shippinno\Labs\Domain\Model\User\UserId;

class Member
{
    /**
     * @var int
     */
    private $surrogateId;

    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var DateTimeImmutable
     */
    private $memberSince;

    /**
     * @param UserId $userId
     * @param DateTimeImmutable $memberSince
     */
    public function __construct(UserId $userId, DateTimeImmutable $memberSince)
    {
        $this->userId = $userId;
        $this->memberSince = $memberSince;
    }

    /**
     * @return UserId
     */
    public function learnerId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return DateTimeImmutable
     */
    public function memberSince(): DateTimeImmutable
    {
        return $this->memberSince;
    }
}
