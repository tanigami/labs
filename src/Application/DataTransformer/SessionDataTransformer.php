<?php

namespace Shippinno\Labs\Application\DataTransformer;

use Shippinno\Labs\Domain\Model\Lab\Session;

interface SessionDataTransformer
{
    /**
     * @param Session $session
     */
    public function write(Session $session): void;

    /**
     * @return mixed
     */
    public function read();
}