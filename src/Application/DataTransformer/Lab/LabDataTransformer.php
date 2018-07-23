<?php

namespace Shippinno\Labs\Application\DataTransformer\Lab;

use Shippinno\Labs\Domain\Model\Lab\Lab;

interface LabDataTransformer
{
    /**
     * @param Lab $lab
     */
    public function write(Lab $lab): void;

    /**
     * @return mixed
     */
    public function read();
}