<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\Lab;

use Shippinno\Labs\Domain\Model\Lab\Session;
use Shippinno\Labs\Domain\Model\Lab\SessionId;

class InMemorySessionRepository
{
    /**
     * @var Session[]
     */
    private $sessions;

    /**
     * {@inheritdoc}
     */
    public function sessionOfId(SessionId $sessionId): ?Session
    {
        return $this->sessions[$sessionId->id()] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function add(Session $session): void
    {
        $this->sessions[$session->sessionId()->id()] = $session;
    }
}