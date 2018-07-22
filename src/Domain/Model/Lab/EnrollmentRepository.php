<?php

namespace Shippinno\Labs\Domain\Model\Lab;

interface EnrollmentRepository
{
    /**
     * @param Enrollment $enrollment
     */
    public function add(Enrollment $enrollment): void;

    /**
     * @param Enrollment $enrollment
     */
    public function remove(Enrollment $enrollment): void;
}