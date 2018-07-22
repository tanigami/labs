<?php

namespace Shippinno\Labs\Application\Query;

class Limiting
{
    /**
     * @var int
     */
    private $limit;

    /**
     * @param int $limit
     */
    public function __construct(int $limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function limit(): int
    {
        return $this->limit;
    }
}
