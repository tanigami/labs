<?php

namespace Shippinno\Labs\Domain\Model\Lab;

interface LabRepository
{
    /**
     * @return Lab[]
     */
    public function all(): array;

    /**
     * @param LabId $labId
     * @return null|Lab
     */
    public function labOfId(LabId $labId): ?Lab;

    /**
     * @return Lab[]
     */
    public function satisfying($specification): array;

    /**
     * @param $specification
     * @return int
     */
    public function countSatisfying($specification): int;

    /**
     * @param Lab $course
     */
    public function add(Lab $course): void;

    /**
     * @param Lab $course
     */
    public function remove(Lab $course): void;
}