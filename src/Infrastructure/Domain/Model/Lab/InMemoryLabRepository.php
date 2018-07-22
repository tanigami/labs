<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\Lab;

use Shippinno\Labs\Domain\Model\Lab\Lab;
use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Domain\Model\Lab\LabRepository;

class InMemoryLabRepository implements LabRepository
{
    /**
     * @var Lab[]
     */
    private $labs;

    /**
     * {@inheritdoc}
     */
    public function labOfId(LabId $labId): ?Lab
    {
        return $this->labs[$labId->id()] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function add(Lab $lab): void
    {
        $this->labs[$lab->labId()->id()] = $lab;
    }

    /**
     * @param Lab $lab
     */
    public function remove(Lab $lab): void
    {
        unset($this->labs[$lab->labId()->id()]);
    }

    /**
     * @return Lab[]
     */
    public function satisfying($specification): array
    {
        // TODO: Implement satisfying() method.
    }

    /**
     * @param $specification
     * @return int
     */
    public function countSatisfying($specification): int
    {
        // TODO: Implement countSatisfying() method.
    }
}
