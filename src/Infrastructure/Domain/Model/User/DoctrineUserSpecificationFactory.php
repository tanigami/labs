<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\User;

use Shippinno\Labs\Domain\Model\User\UserHasSignInEmailAddressSpecification;
use Shippinno\Labs\Domain\Model\User\UserSpecificationFactory;
use Tanigami\ValueObjects\Web\EmailAddress;

class DoctrineUserSpecificationFactory implements UserSpecificationFactory
{
    /**
     * {@inheritdoc}
     * @return UserHasSignInEmailAddressSpecification
     */
    public function userHasSignInEmailAddress(EmailAddress $signinEmailAddress): UserHasSignInEmailAddressSpecification
    {
        return new DoctrineUserHasSignInEmailAddressSpecification($signinEmailAddress);
    }
}