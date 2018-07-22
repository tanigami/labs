<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\User;

use Happyr\DoctrineSpecification\EntitySpecificationRepository;
use Shippinno\Labs\Domain\Model\User\User;
use Shippinno\Labs\Domain\Model\User\UserId;
use Shippinno\Labs\Domain\Model\User\UserRepository;

class DoctrineUserRepository extends EntitySpecificationRepository implements UserRepository
{
    /**
     * {@inheritdoc}
     */
    public function userOfId(UserId $userId): ?User
    {
        /** @var User|null $user */
        $user = $this->find($userId);

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function satisfying($specification, bool $singleResult = false)
    {
        if ($singleResult) {
            return $this->matchOneOrNullResult($specification);
        } else {
            return $this->match($specification);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add(User $user): void
    {
        $this->getEntityManager()->persist($user);
    }
}
