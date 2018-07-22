<?php

namespace Shippinno\Labs\Application\DataTransformer;

use Shippinno\Labs\Domain\Model\Lab\Lab;

class LabDtoDataTransformer implements LabDataTransformer
{
    /**
     * @var Lab
     */
    private $lab;

    /**
     * {@inheritdoc}
     */
    public function write(Lab $lab): void
    {
        $this->lab = $lab;
    }

    /**
     * @return array
     */
    public function read(): array
    {
        return [
            'id' => $this->lab->labId()->id(),
            'name' => $this->lab->name(),
        ];
    }
}