<?php

namespace Shippinno\Labs\Application\Query\Lab;

class FetchLab
{
    /**
     * @var string
     */
    private $labId;

    /**
     * @param string $labId
     */
    public function __construct(string $labId)
    {
        $this->labId = $labId;
    }

    /**
     * @return string
     */
    public function labId(): string
    {
        return $this->labId;
    }
}
