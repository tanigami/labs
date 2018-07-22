<?php

namespace Shippinno\Labs\Domain\Model\Lab;

use Shippinno\Labs\Domain\Model\Common\UnauthorizedActionException;
use Shippinno\Labs\Domain\Model\User\User;

trait LabOwnershipAware
{
    /**
     * @param User $user
     * @param Lab $course
     * @throws UnauthorizedActionException
     */
    private function assertUserOwnsLab(User $user, Lab $lab): void
    {
        if (!$lab->ownerId()->equals($user->userId())) {
            throw new UnauthorizedActionException('User is not authorized to add a session to this course');
        }
    }
}