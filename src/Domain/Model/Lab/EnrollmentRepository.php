<?php

namespace Shippinno\Labs\Domain\Model\Lab;

interface EnrollmentRepository
{
    /**
     * @param Member $enrollment
     */
    public function add(Member $enrollment): void;

    /**
     * @param Member $enrollment
     */
    public function remove(Member $enrollment): void;
}