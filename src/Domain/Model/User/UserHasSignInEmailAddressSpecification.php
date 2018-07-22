<?php

namespace Shippinno\Labs\Domain\Model\User;

use Tanigami\ValueObjects\Web\EmailAddress;

class UserHasSignInEmailAddressSpecification extends UserSpecification
{
    /**
     * @var EmailAddress
     */
    protected $signInEmailAddress;

    /**
     * @param EmailAddress $signInEmailAddress
     */
    public function __construct(EmailAddress $signInEmailAddress)
    {
        parent::__construct();
        $this->signInEmailAddress = $signInEmailAddress;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isSatisfiedBy($user): bool
    {
        return $user->loginCredentials()->emailAddress()->equals($this->signInEmailAddress);
    }
}