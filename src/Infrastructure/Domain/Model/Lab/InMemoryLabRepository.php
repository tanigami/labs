<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\Lab;

use Shippinno\Labs\Domain\Model\Common\Specification;
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
    public function satisfying(Specification $specification): array
    {

        return array_filter(
            $this->labs,
            function (Lab $lab) use ($specification) {
                return $specification->isSatisfiedBy($lab);
            }
        );
    }

    /**
     * @param $specification
     * @return int
     */
    public function countSatisfying($specification): int
    {
        return count($this->satisfying($specification));
    }
}
