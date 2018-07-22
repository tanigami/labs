<?php

namespace Shippinno\Labs\Domain\Model\User;

class User
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var string
     */
    private $nickname;

    /**
     * @param UserId $userId
     * @param string $nickname
     */
    public function __construct(UserId $userId, string $nickname)
    {
        $this->userId = $userId;
        $this->nickname = $nickname;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function nickname(): string
    {
        return $this->nickname;
    }
}
