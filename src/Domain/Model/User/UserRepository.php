<?php

namespace Shippinno\Labs\Domain\Model\User;

interface UserRepository
{
    /**
     * @param UserId $userId
     * @return null|User
     */
    public function userOfId(UserId $userId): ?User;

    /**
     * @param $specification
     * @param bool $singleResult
     * @return User[]|User|null
     */
    public function satisfying($specification, bool $singleResult = false);

    /**
     * @param User $user
     */
    public function save(User $user): void;

    /**
     * @param User $user
     */
    public function remove(User $user): void;
}