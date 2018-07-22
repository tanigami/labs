<?php

namespace Shippinno\Labs\Application\Query;

class OneLab implements Query
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
