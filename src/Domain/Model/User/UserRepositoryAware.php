<?php

namespace Shippinno\Labs\Domain\Model\User;

trait UserRepositoryAware
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function setUserRepository(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return UserRepository
     */
    public function userRepository(): UserRepository
    {
        return $this->userRepository;
    }

    /**
     * @param UserId $userId
     * @return null|User
     * @throws UserNotFoundException
     */
    protected function findUserOrFail(UserId $userId): User
    {
        $user = $this->userRepository()->userOfId($userId);
        if (is_null($user)) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
