<?php

namespace Shippinno\Labs\Application\Command\Lab;

class LeaveLab
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
     * @param string $commanderId
     * @param string $labId
     */
    public function __construct(string $commanderId, string $labId)
    {
        $this->commanderId = $commanderId;
        $this->labId = $labId;
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
}
