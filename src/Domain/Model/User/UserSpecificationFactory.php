<?php

namespace Shippinno\Labs\Domain\Model\User;

use Tanigami\ValueObjects\Web\EmailAddress;

interface UserSpecificationFactory
{
    /**
     * @param EmailAddress $signinEmailAddress
     * @return UserHasSignInEmailAddressSpecification
     */
    public function userHasSignInEmailAddress(EmailAddress $signinEmailAddress): UserHasSignInEmailAddressSpecification;
}