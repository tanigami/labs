<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\User;

use Happyr\DoctrineSpecification\Spec;
use Shippinno\Labs\Domain\Model\User\UserHasSignInEmailAddressSpecification;

class DoctrineUserHasSignInEmailAddressSpecification extends UserHasSignInEmailAddressSpecification
{
    /**
     * {@inheritdoc}
     */
    protected function getSpec()
    {
        return Spec::eq('loginCredentials.emailAddress.emailAddress', $this->signInEmailAddress->emailAddress());
    }
}