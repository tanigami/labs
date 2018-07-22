<?php

namespace Shippinno\Labs\Application\DataTransformer;

use Shippinno\Labs\Domain\Model\User\User;

interface UserDataTransformer
{
    /**
     * @param User $user
     */
    public function write(User $user): void;

    /**
     * @return mixed
     */
    public function read();
}