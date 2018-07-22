<?php

namespace Shippinno\Labs\Domain\Model\Lab;

use DateTimeImmutable;
use Shippinno\Labs\Domain\Model\User\UserId;

class Attendee
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
     * @param UserId $learnerId
     */
    public function __construct(UserId $learnerId)
    {
        $this->userId = $learnerId;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }
}
