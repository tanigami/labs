<?php

namespace Shippinno\Labs\Tests\Unit\Application\Command\Lab;

use Shippinno\Labs\Application\DataTransformer\LabDataTransformer;
use Shippinno\Labs\Domain\Model\Lab\Lab;

class LabAsIsDataTransformer implements LabDataTransformer
{
    /**
     * @var Lab
     */
    private $lab;

    /**
     * @param Lab $lab
     */
    public function write(Lab $lab): void
    {
        $this->lab = $lab;
    }

    /**
     * @return mixed
     */
    public function read()
    {
        return $this->lab;
    }
}