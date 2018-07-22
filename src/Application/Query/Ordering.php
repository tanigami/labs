<?php

namespace Shippinno\Labs\Application\Query;

abstract class Ordering
{
    /**
     * @var string
     */
    public const DIRECTION_ASC = 'ASC';

    /**
     * @var string
     */
    public const DIRECTION_DESC = 'DESC';

    /**
     * @var string
     */
    private $orderBy;

    /**
     * @var string
     */
    private $direction;

    /**
     * @param string $orderBy
     * @param string $direction
     */
    public function __construct(string $orderBy, string $direction)
    {
        $this->orderBy = $orderBy;
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function orderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @return string
     */
    public function direction(): string
    {
        return $this->direction;
    }
}