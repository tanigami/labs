<?php

namespace Shippinno\Labs\Application\DataTransformer;

use Shippinno\Labs\Domain\Model\User\User;

class UserDtoDataTransformer implements UserDataTransformer
{
    /**
     * @var User
     */
    private $user;

    /**
     * @param User $user
     */
    public function write(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function read()
    {
        return [
            'id' => $this->user->userId(),
            'username' => $this->user->username(),
            'signInCredentials' => [
                'emailAddress' => $this->user->loginCredentials()->emailAddress()->emailAddress(),
                'password' => $this->user->loginCredentials()->password(),
            ],
            'apiToken' => $this->user->apiToken()->apiToken(),
        ];
    }
}