<?php

namespace Shippinno\Labs\Application\Query;

use Shippinno\Labs\Domain\Model\Common\Ordering;

class SessionOrdering extends Ordering
{
    /**
     * @var string
     */
    public const ORDER_BY_START = 'start';

    /**
     * @var string
     */
    public const ORDER_BY_END = 'end';
}