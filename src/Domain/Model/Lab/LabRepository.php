<?php

namespace Shippinno\Labs\Domain\Model\Lab;

use Shippinno\Labs\Domain\Model\Common\Specification;

interface LabRepository
{
    /**
     * @param LabId $labId
     * @return null|Lab
     */
    public function labOfId(LabId $labId): ?Lab;

    /**
     * @param Lab $course
     */
    public function add(Lab $course): void;

    /**
     * @param Lab $course
     */
    public function remove(Lab $course): void;

    /**
     * @return Lab[]
     */
    public function satisfying(Specification $specification): array;

    /**
     * @param $specification
     * @return int
     */
    public function countSatisfying(Specification $specification): int;
}