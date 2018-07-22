<?php

namespace Shippinno\Labs\Application\Command\Lab;

class RemoveSession
{
    /**
     * @var string
     */
    private $commanderId;

    /**
     * @var string
     */
    private $labId;

    /**
     * @var string
     */
    private $sessionId;

    /**
     * @param string $commanderId
     * @param string $labId
     * @param string $sessionId
     */
    public function __construct(
        string $commanderId,
        string $labId,
        string $sessionId
    ) {
        $this->commanderId = $commanderId;
        $this->labId = $labId;
        $this->sessionId = $sessionId;
    }

    /**
     * @return string
     */
    public function commanderId(): string
    {
        return $this->commanderId;
    }

    /**
     * @return string
     */
    public function labId(): string
    {
        return $this->labId;
    }

    /**
     * @return string
     */
    public function sessionId(): string
    {
        return $this->sessionId;
    }
}
