<?php

namespace Shippinno\Labs\Domain\Model\User;

class UserBuilder
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
     * @return void
     */
    public function __construct()
    {
        $this->userId = new UserId;
        $this->nickname = 'johndoe';
    }

    /**
     * @return self
     */
    public static function user(): self
    {
        return new self;
    }

    /**
     * @param UserId $userId
     * @return self
     */
    public function withUserId(UserId $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @param string $nickname
     * @return self
     */
    public function withNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * @return User
     */
    public function build(): User
    {
        return new User($this->userId, $this->nickname);
    }
}
