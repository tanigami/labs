<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\User;


use Shippinno\Labs\Domain\Model\User\User;
use Shippinno\Labs\Domain\Model\User\UserId;
use Shippinno\Labs\Domain\Model\User\UserRepository;

class InMemoryUserRepository implements UserRepository
{
    /**
     * @var User[]
     */
    private $users;

    /**
     * {@inheritdoc}
     */
    public function userOfId(UserId $userId): ?User
    {
        return $this->users[$userId->id()] ?? null;
    }

    /**
     * @param $specification
     * @param bool $singleResult
     * @return User[]|User|null
     */
    public function satisfying($specification, bool $singleResult = false)
    {
        // TODO: Implement satisfying() method.
    }

    /**
     * {@inheritdoc}
     */
    public function save(User $user): void
    {
        $this->users[$user->userId()->id()] = $user;
    }

    /**
     * @param User $user
     */
    public function remove(User $user): void
    {
        // TODO: Implement remove() method.
    }
}