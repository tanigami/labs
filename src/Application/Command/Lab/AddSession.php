<?php

namespace Shippinno\Labs\Application\Command\Lab;

use DateTimeImmutable;

class AddSession
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
     * @var string
     */
    private $title;

    /**
     * @var DateTimeImmutable
     */
    private $start;

    /**
     * @var DateTimeImmutable
     */
    private $end;

    /**
     * @var string
     */
    private $description;

    /**
     * @param string $commanderId
     * @param string $labId
     * @param string $sessionId
     * @param string $title
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     * @param string $description
     */
    public function __construct(
        string $commanderId,
        string $labId,
        string $sessionId,
        string $title,
        DateTimeImmutable $start,
        DateTimeImmutable $end,
        string $description
    ) {
        $this->commanderId = $commanderId;
        $this->labId = $labId;
        $this->sessionId = $sessionId;
        $this->title = $title;
        $this->start = $start;
        $this->end = $end;
        $this->description = $description;
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

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return DateTimeImmutable
     */
    public function start(): DateTimeImmutable
    {
        return $this->start;
    }

    /**
     * @return DateTimeImmutable
     */
    public function end(): DateTimeImmutable
    {
        return $this->end;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }
}
